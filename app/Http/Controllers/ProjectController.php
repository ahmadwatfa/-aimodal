<?php

namespace App\Http\Controllers;

use App\Services\SerpApiService;
use App\Services\KeywordToolService;
use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Google;
use App\Models\ReportSection;
use App\Services\GoogleSearchService;
use App\Services\OpenAIService;
use HTMLPurifier;
use HTMLPurifier_Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mpdf\Mpdf;
use Symfony\Component\Intl\Countries;
use PDF;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;

class ProjectController extends Controller
{
    protected $openAIService;
    protected $serpApiService;
    protected $keywordToolService;
    protected $googleSearchService;
    protected $dataRobotService;

    public function __construct(
        OpenAIService $openAIService,
        SerpApiService $serpApiService,
        GoogleSearchService $googleSearchService,
        KeywordToolService $keywordToolService
    ) {
        $this->openAIService = $openAIService;
        $this->serpApiService = $serpApiService;
        $this->googleSearchService = $googleSearchService;
    }
    // $this->keywordToolService = $keywordToolService;



    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::where('user_id', Auth::user()->id)->orderBy('created_at', 'Desc')->get();
        $countries = Countries::getNames('ar');
        return view('projects.index', [
            'projects' => $projects,
            'countries' => $countries,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('projects.create', [
            'countries' => Countries::getNames('ar'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $userId = Auth::user()->id;
        $data = $request->all();
        $data['user_id'] = $userId;

        $project = Project::create($data);


        $query = $request->input('description');
        $location = $request->input('location');

        ReportSection::insert([
            [
                'section_name' => 'problems_and_solutions',
                'project_id' => $project->id,
                'user_id' => Auth::user()->id,
                'content' => "على شكل كود HTML، قم بكتابة **المشاكل والحلول** التي تواجه العملاء في مجال {$query} في {$location}.  
                                     
                             **المشاكل:**  
                             - استخدم عنصر <h2> لكتابة عنوان 'المشاكل'.  
                             - ضع **4 مشاكل رئيسية** داخل <ul>، مع تقديم وصف مختصر لكل مشكلة داخل <li>.  
                             - اجعل المشاكل مترابطة وتعكس التحديات الحقيقية التي يواجهها العملاء.  
        
                             **الحلول:**  
                             - استخدم عنصر <h2> لكتابة عنوان 'الحلول'.  
                             - ضع **4 حلول رئيسية** داخل <ul> بحيث يكون كل حل متوافقًا مع المشكلة المقابلة له.  
                             - استخدم <li> لكل حل، مع وصف مختصر يوضح كيف يعالج المشكلة المذكورة.  
        
                             **مثال على التنسيق المطلوب:**  
                            
                             <h2>المشاكل</h2>
                             <ul>
                                 <li><strong>المشكلة الأولى:</strong> [وصف المشكلة الأولى]</li>
                             </ul>
        
                             <h2>الحلول</h2>
                             <ul>
                                 <li><strong>الحل الأول:</strong> [وصف الحل الأول الذي يعالج المشكلة الأولى]</li>
                             </ul>
                           
                             <br>"
            ],
            [
                'section_name' => 'business_model_1',
                'project_id' => $project->id,
                'user_id' => Auth::user()->id,
                'content' => "على شكل كود HTML، قم بإنشاء الجزء الأول من نموذج العمل لفكرة {$query} في {$location}، بحيث يشمل العناصر التالية:  
                                     
                             🔹 **شرائح العملاء:**  
                             - استخدم <h2> لكتابة عنوان 'شرائح العملاء'.  
                             - ضع خمس شرائح عملاء رئيسية داخل <ul>، مع تقديم وصف مختصر لكل شريحة.  
                             <br>  
                             
                             🔹 **القيمة المقترحة:**  
                             - استخدم <h2> لكتابة عنوان 'القيمة المقترحة'.  
                             - ضع خمس قيم رئيسية داخل <ul> تشرح كيف تحل الفكرة مشكلة العميل أو تقدم ميزة تنافسية.  
                             - ركز على كيفية تحقيق **مكاسب للعميل** وتخفيف **آلامه**، مما يجعل الفكرة ذات قيمة حقيقية.  
                             <br>"
            ],

            [
                'section_name' => 'business_model_2',
                'project_id' => $project->id,
                'user_id' => Auth::user()->id,
                'content' => "على شكل كود HTML، قم بإنشاء الجزء الثاني من نموذج العمل لفكرة {$query} في {$location}، بحيث يشمل العناصر التالية:  
                                     
                             🔹 **القنوات:**  
                             - استخدم <h2> لكتابة عنوان 'القنوات'.  
                             - ضع خمس قنوات رئيسية داخل <ul> توضح كيف سيتم توصيل المنتج أو الخدمة للعملاء.  
                             <br>  
                             
                             🔹 **علاقات العملاء:**  
                             - استخدم <h2> لكتابة عنوان 'علاقات العملاء'.  
                             - ضع خمس استراتيجيات داخل <ul> تشرح كيفية بناء علاقات قوية مع العملاء المستهدفين.  
                             <br>"
            ],

            [
                'section_name' => 'business_model_3',
                'project_id' => $project->id,
                'user_id' => Auth::user()->id,
                'content' => "على شكل كود HTML، قم بإنشاء الجزء الثالث من نموذج العمل لفكرة {$query} في {$location}، بحيث يشمل العناصر التالية:  
                                     
                             🔹 **مصادر الإيرادات:**  
                             - استخدم <h2> لكتابة عنوان 'مصادر الإيرادات'.  
                             - ضع خمس طرق رئيسية داخل <ul> توضح كيفية تحقيق الأرباح من الفكرة.  
                             <br>  
                             
                             🔹 **الموارد الرئيسية:**  
                             - استخدم <h2> لكتابة عنوان 'الموارد الرئيسية'.  
                             - ضع خمس موارد رئيسية داخل <ul> توضح ما هو مطلوب لتنفيذ الفكرة بنجاح.  
                             <br>"
            ],

            [
                'section_name' => 'business_model_4',
                'project_id' => $project->id,
                'user_id' => Auth::user()->id,
                'content' => "على شكل كود HTML، قم بإنشاء الجزء الرابع من نموذج العمل لفكرة {$query} في {$location}، بحيث يشمل العناصر التالية:  
                                     
                             🔹 **الأنشطة الرئيسية:**  
                             - استخدم <h2> لكتابة عنوان 'الأنشطة الرئيسية'.  
                             - ضع خمس أنشطة رئيسية داخل <ul> تشرح ما يجب القيام به لإنجاح الفكرة.  
                             <br>  
                             
                             🔹 **الشراكات الرئيسية:**  
                             - استخدم <h2> لكتابة عنوان 'الشراكات الرئيسية'.  
                             - ضع خمس شراكات رئيسية داخل <ul> تحدد الجهات التي يمكن التعاون معها لإنجاح الفكرة.  
                             <br>  
                             
                             🔹 **هيكل التكاليف:**  
                             - استخدم <h2> لكتابة عنوان 'هيكل التكاليف'.  
                             - ضع خمس نقاط رئيسية داخل <ul> توضح التكاليف الرئيسية للمشروع.  
                             <br>"
            ]
        ]);



        $sections = ReportSection::where('project_id', $project->id)->where('completed', false)->get()->toArray();

        $openAIResults = $this->openAIService->generateText($sections);

        $report_sections = ReportSection::where('project_id', $project->id)->get();


        return view('projects.show', [
            'report_sections' => $report_sections,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $report_sections = ReportSection::where('project_id', $project->id)->get();
        $interestData = $this->serpApiService->getInterestData($project->id);
        $googleResults = Google::where('project_id', $project->id)->get();

        // إعداد البيانات للعرض
        $labels = $interestData->pluck('date'); // توسيع القيم للحصول على التواريخ
        $values = $interestData->pluck('value'); // توسيع القيم للحصول على القيم

        return view('projects.show', [
            'report_sections' => $report_sections,
            'googleResults' => $googleResults,
            'labels' => json_encode($labels),
            'values' => json_encode($values),
        ]);
    }
    function word_generator(Request $request)
    {
        $report_sections = ReportSection::where('project_id', $request->id)->get();
        $htmlContent = view('reportPdf', [
            'report_sections' => $report_sections,
        ])->render();

        // تنظيف الـ HTML باستخدام HTML Purifier
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);
        $cleanHtml = $purifier->purify($htmlContent);

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        // إضافة الـ HTML النظيف إلى ملف Word
        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $cleanHtml, false, false);

        // إعداد اسم الملف وتهيئة التنزيل
        $fileName = 'reportIdea.docx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header("Content-Disposition: attachment; filename=\"{$fileName}\"");
        header('Cache-Control: max-age=0');

        // حفظ الملف كتنزيل
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save("php://output");
        exit;
    }
    function pdf_generator(Request $request)
    {
        $report_sections = ReportSection::where('project_id', $request->id)->get();

        $pdf = PDF::loadView('reportPdf', [
            'report_sections' => $report_sections,
        ]);
        $pdf->autoLangToFont = true;
        $pdf->autoScriptToLang = true;
        $pdf->autoArabic = true;

        return $pdf->stream('reportIdea.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
    }
}
