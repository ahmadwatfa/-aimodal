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
                'content' => "على شكل JSON، قم بكتابة **المشاكل والحلول** التي تواجه العملاء في مجال {$query} في {$location}.  
        
                                     **المشاكل:**  
                             
                                     - اجعل المشاكل مترابطة وتعكس التحديات الحقيقية التي يواجهها العملاء.  
        
                                     **الحلول:**  
                                     - ضع **4 حلول رئيسية** بحيث يكون كل حل متوافقًا مع المشكلة المقابلة له.  
                                     -  لكل حل، مع وصف مختصر يوضح كيف يعالج المشكلة المذكورة.  
        
                **المخرجات المتوقعة:**  
                
                {
                  \"problems\": [
                    \"المشكلة الاولى : [وصف المشكلة الاولى]\",
                    \"المشكلة الثانية : [وصف المشكلة الثانية]\",
                    \"المشكلة الثالثة : [وصف المشكلة الثالثة]\",
                    \"المشكلة الرابعة : [وصف المشكلة الرابعة]\",
                    
                  ],
                  \"solutions\": [
                    \"الحل الاول : [وصف الحل الاول]\",
                    \"الحل الثاني : [وصف الحل الثاني]\",
                    \"الحل الثالث : [وصف الحل الثالث]\",
                    \"الحل الرابع : [وصف الحل الرابع]\",
                  
                  ]
                }"
            ],
            [
                'section_name' => 'customer_segments_and_relationships',
                'project_id' => $project->id,
                'user_id' => Auth::user()->id,
                'content' => "على شكل JSON، قم بكتابة **ثلاث شرائح عملاء رئيسية** لفكرة {$query} في {$location}، متبوعة **بثلاث استراتيجيات لبناء علاقات العملاء**.  
                **المخرجات المتوقعة:**  
                
                {
                  \"customer_segments\": [
                    \"شريحة العملاء 1: [وصف الشريحة الأولى]\",
                    \"شريحة العملاء 2: [وصف الشريحة الثانية]\",
                    \"شريحة العملاء 3: [وصف الشريحة الثالثة]\",
                  ],
                  \"customer_relationships\": [
                    \"استراتيجية 1: [وصف استراتيجية العلاقة الأولى]\",
                    \"استراتيجية 2: [وصف استراتيجية العلاقة الثانية]\",
                    \"استراتيجية 3: [وصف استراتيجية العلاقة الثالثة]\",
                  ]
                }
                "
            ],
            [
                'section_name' => 'value_proposition',
                'project_id' => $project->id,
                'user_id' => Auth::user()->id,
                'content' => "على شكل JSON، قم بكتابة **خمس قيم مقترحة** لفكرة {$query} في {$location} تبين كيف تحل الفكرة مشكلة العملاء أو تقدم ميزة تنافسية.  
                             - ركز على كيفية تحقيق **مكاسب للعميل** وتخفيف **آلامه**، مما يجعل الفكرة ذات قيمة حقيقية.  

                **المخرجات المتوقعة:**  
              
                {
                  \"value_proposition\": [
                    \"القيمة 1: [وصف القيمة الأولى]\",
                    \"القيمة 2: [وصف القيمة الثانية]\",
                    \"القيمة 3: [وصف القيمة الثالثة]\",
                    \"القيمة 4: [وصف القيمة الرابعة]\",
                    \"القيمة 5: [وصف القيمة الخامسة]\"
                  ]
                }
                "
            ],
            [
                'section_name' => 'marketing_channels',
                'project_id' => $project->id,
                'user_id' => Auth::user()->id,
                'content' => "على شكل JSON، قم بكتابة **خمس قنوات تسويقية رئيسية** يمكن استخدامها للوصول إلى العملاء في لفكرة {$query} في {$location}.  
                **المخرجات المتوقعة:**  
                
                {
                  \"marketing_channels\": [
                    \"القناة التسويقية 1: [وصف القناة الأولى]\",
                    \"القناة التسويقية 2: [وصف القناة الثانية]\",
                    \"القناة التسويقية 3: [وصف القناة الثالثة]\",
                    \"القناة التسويقية 4: [وصف القناة الرابعة]\",
                    \"القناة التسويقية 5: [وصف القناة الخامسة]\"
                  ]
                }
                "
            ],
            [
                'section_name' => 'sales_channels',
                'project_id' => $project->id,
                'user_id' => Auth::user()->id,
                'content' => "على شكل JSON، قم بكتابة **خمس قنوات بيع رئيسية** يمكن استخدامها لتوصيل المنتج أو الخدمة للعملاء في لفكرة {$query} في {$location}.  
                **المخرجات المتوقعة:**  
                  
                {
                  \"sales_channels\": [
                    \"قناة البيع 1: [وصف القناة الأولى]\",
                    \"قناة البيع 2: [وصف القناة الثانية]\",
                    \"قناة البيع 3: [وصف القناة الثالثة]\",
                    \"قناة البيع 4: [وصف القناة الرابعة]\",
                    \"قناة البيع 5: [وصف القناة الخامسة]\"
                  ]
                }
                 "
            ],
            [
                'section_name' => 'competitive_advantage',
                'project_id' => $project->id,
                'user_id' => Auth::user()->id,
                'content' => "على شكل JSON، قم بكتابة **خمس ميزات تنافسية رئيسية** لفكرة {$query} في {$location}.  
                **المخرجات المتوقعة:**  
                 
                {
                  \"competitive_advantage\": [
                    \"الميزة التنافسية 1: [وصف الميزة الأولى]\",
                    \"الميزة التنافسية 2: [وصف الميزة الثانية]\",
                    \"الميزة التنافسية 3: [وصف الميزة الثالثة]\",
                    \"الميزة التنافسية 4: [وصف الميزة الرابعة]\",
                    \"الميزة التنافسية 5: [وصف الميزة الخامسة]\"
                  ]
                }
                 "
            ],
            [
                'section_name' => 'revenue_streams',
                'project_id' => $project->id,
                'user_id' => Auth::user()->id,
                'content' => "على شكل JSON، قم بإنشاء **مصادر الإيرادات** لفكرة {$query} في {$location}.  
                    **المخرجات المتوقعة:**  
            
                    {
                      \"revenue_streams\": [
                        \"مصدر الإيرادات 1: [وصف المصدر الأول]\",
                        \"مصدر الإيرادات 2: [وصف المصدر الثاني]\",
                        \"مصدر الإيرادات 3: [وصف المصدر الثالث]\",
                        \"مصدر الإيرادات 4: [وصف المصدر الرابع]\",
                        \"مصدر الإيرادات 5: [وصف المصدر الخامس]\"
                      ]
                    }
                    "
            ],
            [
                'section_name' => 'key_resources',
                'project_id' => $project->id,
                'user_id' => Auth::user()->id,
                'content' => "على شكل JSON، قم بإنشاء **الموارد الرئيسية** لفكرة {$query} في {$location}.  
                    **المخرجات المتوقعة:**  
            
                    {
                      \"key_resources\": [
                        \"المورد الرئيسي 1: [وصف المورد الأول]\",
                        \"المورد الرئيسي 2: [وصف المورد الثاني]\",
                        \"المورد الرئيسي 3: [وصف المورد الثالث]\",
                        \"المورد الرئيسي 4: [وصف المورد الرابع]\",
                        \"المورد الرئيسي 5: [وصف المورد الخامس]\"
                      ]
                    }
                    "
            ],
            [
                'section_name' => 'key_activities',
                'project_id' => $project->id,
                'user_id' => Auth::user()->id,
                'content' => "على شكل JSON، قم بإنشاء **الأنشطة الرئيسية** لفكرة {$query} في {$location}.  
                    **المخرجات المتوقعة:**  
            
                    {
                      \"key_activities\": [
                        \"النشاط الرئيسي 1: [وصف النشاط الأول]\",
                        \"النشاط الرئيسي 2: [وصف النشاط الثاني]\",
                        \"النشاط الرئيسي 3: [وصف النشاط الثالث]\",
                        \"النشاط الرئيسي 4: [وصف النشاط الرابع]\",
                        \"النشاط الرئيسي 5: [وصف النشاط الخامس]\"
                      ]
                    }
                    "
            ],
            [
                'section_name' => 'key_partnerships',
                'project_id' => $project->id,
                'user_id' => Auth::user()->id,
                'content' => "على شكل JSON، قم بإنشاء **الشراكات الرئيسية** لفكرة {$query} في {$location}.  
                    **المخرجات المتوقعة:**  
            
                    {
                      \"key_partnerships\": [
                        \"الشراكة الرئيسية 1: [وصف الشراكة الأولى]\",
                        \"الشراكة الرئيسية 2: [وصف الشراكة الثانية]\",
                        \"الشراكة الرئيسية 3: [وصف الشراكة الثالثة]\",
                        \"الشراكة الرئيسية 4: [وصف الشراكة الرابعة]\",
                        \"الشراكة الرئيسية 5: [وصف الشراكة الخامسة]\"
                      ]
                    }
                    "
            ],
            [
                'section_name' => 'cost_structure',
                'project_id' => $project->id,
                'user_id' => Auth::user()->id,
                'content' => "على شكل JSON، قم بإنشاء **هيكل التكاليف** لفكرة {$query} في {$location}.  
                    **المخرجات المتوقعة:**  
            
                    {
                      \"cost_structure\": [
                        \"التكلفة 1: [وصف التكلفة الأولى]\",
                        \"التكلفة 2: [وصف التكلفة الثانية]\",
                        \"التكلفة 3: [وصف التكلفة الثالثة]\",
                        \"التكلفة 4: [وصف التكلفة الرابعة]\",
                        \"التكلفة 5: [وصف التكلفة الخامسة]\"
                      ]
                    }
                    "
            ]


        ]);





        // ReportSection::insert([
        //     [
        //         'section_name' => 'problems_and_solutions',
        //         'project_id' => $project->id,
        //         'user_id' => Auth::user()->id,
        //         'content' => "على شكل كود HTML، قم بكتابة **المشاكل والحلول** التي تواجه العملاء في مجال {$query} في {$location}.  

        //                      **المشاكل:**  
        //                      - استخدم عنصر <h2> لكتابة عنوان 'المشاكل'.  
        //                      - ضع **4 مشاكل رئيسية** داخل <ul>، مع تقديم وصف مختصر لكل مشكلة داخل <li>.  
        //                      - اجعل المشاكل مترابطة وتعكس التحديات الحقيقية التي يواجهها العملاء.  

        //                      **الحلول:**  
        //                      - استخدم عنصر <h2> لكتابة عنوان 'الحلول'.  
        //                      - ضع **4 حلول رئيسية** داخل <ul> بحيث يكون كل حل متوافقًا مع المشكلة المقابلة له.  
        //                      - استخدم <li> لكل حل، مع وصف مختصر يوضح كيف يعالج المشكلة المذكورة.  

        //                      **مثال على التنسيق المطلوب:**  

        //                      <h2>المشاكل</h2>
        //                      <ul>
        //                          <li><strong>المشكلة الأولى:</strong> [وصف المشكلة الأولى]</li>
        //                      </ul>

        //                      <h2>الحلول</h2>
        //                      <ul>
        //                          <li><strong>الحل الأول:</strong> [وصف الحل الأول الذي يعالج المشكلة الأولى]</li>
        //                      </ul>

        //                      <br>"
        //     ],
        //     [
        //         'section_name' => 'business_model_1',
        //         'project_id' => $project->id,
        //         'user_id' => Auth::user()->id,
        //         'content' => "على شكل كود HTML، قم بإنشاء الجزء الأول من نموذج العمل لفكرة {$query} في {$location}، بحيث يشمل العناصر التالية:  

        //                      🔹 **شرائح العملاء:**  
        //                      - استخدم <h2> لكتابة عنوان 'شرائح العملاء'.  
        //                      - ضع خمس شرائح عملاء رئيسية داخل <ul>، مع تقديم وصف مختصر لكل شريحة.  
        //                      <br>  

        //                      🔹 **القيمة المقترحة:**  
        //                      - استخدم <h2> لكتابة عنوان 'القيمة المقترحة'.  
        //                      - ضع خمس قيم رئيسية داخل <ul> تشرح كيف تحل الفكرة مشكلة العميل أو تقدم ميزة تنافسية.  
        //                      - ركز على كيفية تحقيق **مكاسب للعميل** وتخفيف **آلامه**، مما يجعل الفكرة ذات قيمة حقيقية.  
        //                      <br>"
        //     ],

        //     [
        //         'section_name' => 'business_model_2',
        //         'project_id' => $project->id,
        //         'user_id' => Auth::user()->id,
        //         'content' => "على شكل كود HTML، قم بإنشاء الجزء الثاني من نموذج العمل لفكرة {$query} في {$location}، بحيث يشمل العناصر التالية:  

        //                      🔹 **القنوات:**  
        //                      - استخدم <h2> لكتابة عنوان 'القنوات'.  
        //                      - ضع خمس قنوات رئيسية داخل <ul> توضح كيف سيتم توصيل المنتج أو الخدمة للعملاء.  
        //                      <br>  

        //                      🔹 **علاقات العملاء:**  
        //                      - استخدم <h2> لكتابة عنوان 'علاقات العملاء'.  
        //                      - ضع خمس استراتيجيات داخل <ul> تشرح كيفية بناء علاقات قوية مع العملاء المستهدفين.  
        //                      <br>"
        //     ],

        //     [
        //         'section_name' => 'business_model_3',
        //         'project_id' => $project->id,
        //         'user_id' => Auth::user()->id,
        //         'content' => "على شكل كود HTML، قم بإنشاء الجزء الثالث من نموذج العمل لفكرة {$query} في {$location}، بحيث يشمل العناصر التالية:  

        //                      🔹 **مصادر الإيرادات:**  
        //                      - استخدم <h2> لكتابة عنوان 'مصادر الإيرادات'.  
        //                      - ضع خمس طرق رئيسية داخل <ul> توضح كيفية تحقيق الأرباح من الفكرة.  
        //                      <br>  

        //                      🔹 **الموارد الرئيسية:**  
        //                      - استخدم <h2> لكتابة عنوان 'الموارد الرئيسية'.  
        //                      - ضع خمس موارد رئيسية داخل <ul> توضح ما هو مطلوب لتنفيذ الفكرة بنجاح.  
        //                      <br>"
        //     ],

        //     [
        //         'section_name' => 'business_model_4',
        //         'project_id' => $project->id,
        //         'user_id' => Auth::user()->id,
        //         'content' => "على شكل كود HTML، قم بإنشاء الجزء الرابع من نموذج العمل لفكرة {$query} في {$location}، بحيث يشمل العناصر التالية:  

        //                      🔹 **الأنشطة الرئيسية:**  
        //                      - استخدم <h2> لكتابة عنوان 'الأنشطة الرئيسية'.  
        //                      - ضع خمس أنشطة رئيسية داخل <ul> تشرح ما يجب القيام به لإنجاح الفكرة.  
        //                      <br>  

        //                      🔹 **الشراكات الرئيسية:**  
        //                      - استخدم <h2> لكتابة عنوان 'الشراكات الرئيسية'.  
        //                      - ضع خمس شراكات رئيسية داخل <ul> تحدد الجهات التي يمكن التعاون معها لإنجاح الفكرة.  
        //                      <br>  

        //                      🔹 **هيكل التكاليف:**  
        //                      - استخدم <h2> لكتابة عنوان 'هيكل التكاليف'.  
        //                      - ضع خمس نقاط رئيسية داخل <ul> توضح التكاليف الرئيسية للمشروع.  
        //                      <br>"
        //     ]
        // ]);



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
