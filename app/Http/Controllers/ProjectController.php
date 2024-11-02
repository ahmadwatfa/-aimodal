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

        $idea = $request->input('idea');
        $query = $request->input('description');
        $location = $request->input('location');
        $type = $request->input('type');
        $category = $request->input('category');
        $target_audience = $request->input('target_audience');
        $revenue_model = $request->input('revenue_model');
        $keywordsJson = $request->input('keywords');
        if ($keywordsJson) {
            $keywordsArray = json_decode($keywordsJson, true);
            $keywords = array_map(function ($keyword) {
                return $keyword['value'];
            }, $keywordsArray);

            // تحويل المصفوفة إلى سلسلة نصية
            $keywordsString = implode(', ', $keywords);
        } else {
            $keywordsString = ' ';
        }

        $example = "<h3>نظرة عامة على سوق مطاعم المشاوي</h3>
                    <p><strong>الطلب العالمي على مطاعم المشاوي</strong><br>
                    سوق مطاعم المشاوي يشهد نموًا متزايدًا على مستوى العالم، حيث تزداد شعبية الطعام المشوي كخيار صحي ولذيذ بين المستهلكين. تشير إحصاءات الصناعة إلى أن المطاعم التي تقدم اللحوم المشوية تجذب قاعدة عملاء واسعة، خاصة مع التركيز المتزايد على جودة المكونات وطريقة التحضير...<br>
                    </p>
                    <p><strong>حجم السوق</strong><br>
                    في السعودية، تزداد شعبية مطاعم المشاوي بشكل ملحوظ نظرًا للتغيرات في تفضيلات الطعام، وزيادة الاهتمام بالتجارب الغذائية المتنوعة. يعزز النمو السكاني وارتفاع معدلات الدخل المتاح الطلب على المطاعم التي تقدم تجربة طعام مميزة مثل المشاوي. يعد هذا السوق جزءًا مهمًا من القطاع الغذائي...<br>
                    </p>
                    <p><strong>الطلب على مطاعم المشاوي في السعودية</strong><br>
                    في السعودية، تزداد شعبية مطاعم المشاوي بشكل ملحوظ نظرًا للتغيرات في تفضيلات الطعام، وزيادة الاهتمام بالتجارب الغذائية المتنوعة. يعزز النمو السكاني وارتفاع معدلات الدخل المتاح الطلب على المطاعم التي تقدم تجربة طعام مميزة مثل المشاوي. يعد هذا السوق جزءًا مهمًا من القطاع الغذائي...<br>
                    </p>";
        $example_market = "
                    <p><strong>حجم السوق TAM (Total Addressable Market)</strong><br>
                    رقم مليار العملة
                    </p>
                    <p><strong>حجم السوق SAM (Serviceable Available Market) </strong><br>
                    رقم مليار العملة
                    </p>
                    <p><strong>حجم السوق SOM (Serviceable Obtainable Market)</strong><br>
                    رقم مليار العملة
                    </p>
                    ";
        $example_industry = "
                    <p><strong>هامش الربح الإجمالي (الرقم)</strong><br>
                    شرح عن الرقم
                    </p>
                    <p><strong>هامش الربح التشغيلي (الرقم)</strong><br>
                    شرح عن الرقم
                    </p>";
        $example_swot = "<h4>نقاط القوة</h4>
        <p><strong>توفير التكاليف:</strong>: الشرح</p>";
        ReportSection::insert([
            [
                'section_name' => 'overview',
                'project_id' => $project->id,
                'user_id' => Auth::user()->id,
                'content' => "توفير نظرة عامة شاملة على سوق {$query} استخدم إحصاءات الصناعة لتوضيح الطلب على {$query}، وخاصة في {$location} وعلى مستوى العالم.
                                                                تقديم رؤى حول سبب كون التوقيت مناسبًا لإطلاق هذا {$type} في {$location}، مع مراعاة العوامل الاجتماعية والاقتصادية ومعدلات التبني.
                                                                قم بتضمين حجم السوقين العالمي والمحلي في {$location} فيما يعرف ب tam ,sam and som كارقام تفصيلة لحجم كل سوق منهم وان يكون النص وفق الترتيب التالي:الطلب العالمي , نظرة على حجم السوق,الطلب المحلي , ارقام حجم السوق
                                                                يجب أن تتكون كل فقرة من 15 سطور وكل نقطة في فقرة منفصلة  وان يكون حجم السوق مثل هذه 
                                     الصيغة {$example_market} كأرقام فقط، مع عنوان لكل نقطة ووضع <br> في نهاية كل فقرة  مع وضع العنوان الرئيسي في عنصر h3 والفقرة في عنصر p مثل هذه الصيغة {$example}"
            ],
            [
                'section_name' => 'executive_summary',
                'project_id' => $project->id,
                'user_id' => Auth::user()->id,
                'content' => "قدِّم ملخصًا تنفيذيًا موجزًا ​​ومفصلاً يتضمن مفهوم {$query} واستراتيجيات التسعير. صرِّح بإمكانات السوق لهذا {$category} مع الأخذ في الاعتبار الاهتمام المتزايد في {$location}.أدرج تفاصيل التسعير
                                                                يجب أن يتكون النص فقرة واحدة يتضمن الحديث عن الامور المطلوبة وان يتكون من  15 سطر مع مقسمة على اربع فقرات مع وضع الفقرة ضمن عنصر p"
            ],
            [
                'section_name' => 'idea_description',
                'project_id' => $project->id,
                'user_id' => Auth::user()->id,
                'content' => "تقديم شرح مفصل لفكرة {$query} مع توضيح الميزات الرئيسية وشرح وصف المشروع
                                                                يجب أن يتكون النص من عدة فقرات، كل نقطة في فقرة منفصلة، مع عنوان لكل نقطة ووضع <br> في نهاية كل فقرة  مع وضع العنوان الرئيسي في عنصر h3 والفقرة في عنصر p وتتكون من اربعة سطور لكل فقرة مثل هذه الصيغة {$example}"
            ],
            [
                'section_name' => 'business_model_1',
                'project_id' => $project->id,
                'user_id' => Auth::user()->id,
                'content' => "المشكلة: اذكر ثلاث مشكلات على شكل نقاط التي تحلها الفكرة التالية: {$query} في {$location}
                                                                الحل: اذكر على شكل ثلاث نقاط كيف يقدم {$query} حلاً شاملاً في {$location}
                                                                عرض القيمة: قم بإدراج شرح متعمق لكيفية تقديم {$query} لقيمة فريدة                           
                                                                يجب أن يتكون النص من عدة نقاط كل نقطة في فقرة منفصلة على شكل ثلاث نقاط لكل قسم بدون شرح مع وضع النقاط في strong، مع عنوان لكل نقطة ووضع 
                                                                <br> في نهاية كل فقرة  مع وضع العنوان الرئيسي في عنصر h3 والفقرة في عنصر p"
            ],
            [
                'section_name' => 'business_model_2',
                'project_id' => $project->id,
                'user_id' => Auth::user()->id,
                'content' => "شرائح العملاء: حدد الجمهور المستهدف المحدد لفكرة {$query}
                                                                حدد الشرائح الثانوية المحتملة للفكرة.
                                                                القنوات: قدم خطة مفصلة حول كيفية توزيع الفكرة. يجب أن يتضمن ذلك:
                                                                المنصات الموجودة عبر الإنترنت
                                                                المبيعات المباشرة.                        
                                                                يجب أن يتكون النص من عدة نقاط كل نقطة في فقرة منفصلة على شكل ثلاث نقاط لكل قسم بدون شرح مع وضع النقاط في strong، مع عنوان لكل نقطة ووضع 
                                                                <br> في نهاية كل فقرة  مع وضع العنوان الرئيسي في عنصر h3 والفقرة في عنصر p"
            ],
            [
                'section_name' => 'business_model_3',
                'project_id' => $project->id,
                'user_id' => Auth::user()->id,
                'content' => "علاقات العملاء: اشرح كيف تخطط الشركة لبناء علاقات العملاء والحفاظ عليها لفكرة {$query}.
                                                                قم بتضمين التفاصيل حول:
                                                                دعم العملاء عبر تطبيق الهاتف المحمول.
                                                                برنامج ولاء للمشتركين على المدى الطويل.
                                                                حلقات التغذية الراجعة لجمع البيانات وتحسين المنتج باستمرار.
                                                               
                                                                يجب أن يتكون النص من عدة نقاط كل نقطة في فقرة منفصلة على شكل ثلاث نقاط لكل قسم بدون شرح مع وضع النقاط في strong ، مع عنوان لكل نقطة ووضع 
                                                                <br> في نهاية كل فقرة  مع وضع العنوان الرئيسي في عنصر h3 والفقرة في عنصر p"
            ],
            [
                'section_name' => 'business_model_4',
                'project_id' => $project->id,
                'user_id' => Auth::user()->id,
                'content' => " مصادر الإيرادات: قم بإيجاز مصادر الدخل المختلفة لفكرة {$query} .
                                                                الأنشطة الرئيسية: قم بإدراج وصف الأنشطة الأساسية اللازمة لتشغيل الأعمال للفكرة .
                                                                الموارد الرئيسية: قم بإدراج الموارد الرئيسية المطلوبة للفكرة.                       
                                                                يجب أن يتكون النص من عدة نقاط كل نقطة في فقرة منفصلة على شكل ثلاث نقاط لكل قسم بدون شرح مع وضع النقاط في strong، مع عنوان لكل نقطة ووضع 
                                                                <br> في نهاية كل فقرة  مع وضع العنوان الرئيسي في عنصر h3 والفقرة في عنصر p"
            ],
            [
                'section_name' => 'business_model_5',
                'project_id' => $project->id,
                'user_id' => Auth::user()->id,
                'content' => " الشراكات الرئيسية: حدد الشراكات المحتملة لفكرة {$query}.
                                                                هيكل التكلفة: قم بتقديم تفصيل للتكاليف الرئيسية المرتبطة بالفكرة                           
                                                                يجب أن يتكون النص من عدة نقاط كل نقطة في فقرة منفصلة على شكل ثلاث نقاط لكل قسم بدون شرح مع وضع النقاط في strong، مع عنوان لكل نقطة ووضع 
                                                                <br> في نهاية كل فقرة  مع وضع العنوان الرئيسي في عنصر h3 والفقرة في عنصر p"
            ],
            [
                'section_name' => 'swot_analysis',
                'project_id' => $project->id,
                'user_id' => Auth::user()->id,
                'content' => "ضمن تحليل SWOT ل {$query} في {$location} ،  توفير نقاط موسعة لـ: نقاط القوة والضعف فقط مع وضع مقدمة عن تحليل swot وذكر اهميته على شكل فقرة قبل البطاقات في عنصر p مع اعطائه margin بينه وبين البطاقات .
                                                               يجب ان يكون النص عبارة عن اثنين div كبطاقات card مع اعطاء لون لكل card و margin-top:10px لكل بطاقة مع وضع padding داخلي للبطاقات وذكر العناصر الخاصة بالقسم بداخل البطاقة ك ul وان يكون لكل قسم ثلاث نقاط مع وضع عنوان النقطة في عنصر strong ثم الشرح  مع شرح بسيط لكل نقطة وان يكون تنسيق css في داخل العناصر بدون بالطبع ساقوم او التعقيب على التحليل اريد النص فقط كالصيغة التالية {$example_swot}"
            ],
            [
                'section_name' => 'swot_analysis_1',
                'project_id' => $project->id,
                'user_id' => Auth::user()->id,
                'content' => "ضمن تحليل SWOT ل {$query} في {$location} ،  توفير نقاط موسعة لـ: نقاط الفرص والتهديدات فقط .
                                                               يجب ان يكون النص عبارة عن اثنين div كبطاقات card مع اعطاء لون لكل card و margin-top:10px لكل بطاقة مع وضع padding داخلي للبطاقات وذكر العناصر الخاصة بالقسم بداخل البطاقة ك ul  وان يكون لكل قسم ثلاث نقاط مع وضع عنوان النقطة في عنصر strong ثم الشرح للعناصر الرئيسية ثم يليها الشرح كالمثال التالي {$example_swot} مع شرح بسيط لكل نقطة وان يكون تنسيق css في داخل العناصر بدون بالطبع ساقوم او التعقيب على التحليل اريد النص فقط كالصيغة التالية {$example_swot}"
            ],
            [
                'section_name' => 'pestel_analysis',
                'project_id' => $project->id,
                'user_id' => Auth::user()->id,
                'content' => "تحليل العوامل السياسية والاقتصادية المؤثرة على {$query} في {$location} فقط دون كتابة اي عوامل اخرى ، والمعروف باسم تحليل PESTEL مع وضع مقدمة عن التحليل وذكر اهميته على شكل فقرة قبل البطاقات في عنصر p مع اعطائه margin بينه وبين البطاقات.
                                                          يجب ان يكون النص عبارة عن اثنين div كبطاقات card مع اعطاء لون لكل card و margin-top:10px لكل بطاقة مع وضع padding داخلي للبطاقات وذكر العناصر الخاصة بالقسم بداخل البطاقة ك ul  وان يكون لكل قسم ثلاث نقاط مع وضع عنوان كل نقطة في عنصر strong ثم الشرح  مع شرح بسيط لكل نقطة وان يكون تنسيق css في داخل العناصر بدون بالطبع ساقوم اريد النص فقط كالصيغة التالية {$example_swot}"
            ],
            [
                'section_name' => 'pestel_analysis_1',
                'project_id' => $project->id,
                'user_id' => Auth::user()->id,
                'content' => "تحليل العوامل الاجتماعية و القانونية فقط  دون كتابة اي عوامل اخرى  المؤثرة على {$query} في {$location} ضمن تحليل pestel 
                                                          يجب ان يكون النص عبارة عن اثنين div كبطاقات card مع اعطاء لون لكل card و margin-top:10px لكل بطاقة مع وضع padding داخلي للبطاقات وذكر العناصر الخاصة بالقسم بداخل البطاقة ك ul  وان يكون لكل قسم ثلاث نقاط مع وضع عنوان كل نقطة في عنصر strong ثم الشرح مع شرح بسيط لكل نقطة وان يكون تنسيق css في داخل العناصر بدون بالطبع ساقوم اريد النص فقط كالصيغة التالية {$example_swot}"
            ],
            [
                'section_name' => 'pestel_analysis_2',
                'project_id' => $project->id,
                'user_id' => Auth::user()->id,
                'content' => "تحليل العوامل التكنولوجية والبيئية فقط  دون كتابة اي عوامل اخرى المؤثرة على {$query} في {$location} ضمن تحليل pestel 
                                                          يجب ان يكون النص عبارة عن اثنين div كبطاقات card مع اعطاء لون لكل card و margin-top:10px لكل بطاقة مع وضع padding داخلي للبطاقات وذكر العناصر الخاصة بالقسم بداخل البطاقة ك ul  وان يكون لكل قسم ثلاث نقاط مع وضع العنوان في عنصر strong ثم الشرح مع شرح بسيط لكل نقطة وان يكون تنسيق css في داخل العناصر بدون بالطبع ساقوم اريد النص فقط كالصيغة التالية {$example_swot}"
            ],
            [
                'section_name' => 'porter_analysis',
                'project_id' => $project->id,
                'user_id' => Auth::user()->id,
                'content' => " ضمن تحليل قوى بورتر الخمس تحليل التهديد بالمنافسة من الشركات المنافسة , التهديد من الداخلين الجدد إلى الصناعة , التهديدات من الخدمات البديلة فقط على {$query} في {$location} مع وضع مقدمة عن التحليل وذكر اهميته على شكل فقرة قبل البطاقات في عنصر p مع اعطائه margin بينه وبين البطاقات.
                                              يجب ان يكون النص عبارة عن ثلاث div كبطاقات card مع اعطاء لون لكل card و margin-top:10px لكل بطاقة مع وضع padding داخلي للبطاقات وذكر العناصر الخاصة بالقسم بداخل البطاقة ك ul  وان يكون لكل قسم ثلاث نقاط مع وضع العنوان في عنصر strong ثم الشرح مع شرح بسيط لكل نقطة وان يكون تنسيق css في داخل العناصر بدون بالطبع ساقوم اريد النص فقط كالصيغة التالية {$example_swot}"
            ],
            [
                'section_name' => 'porter_analysis_1',
                'project_id' => $project->id,
                'user_id' => Auth::user()->id,
                'content' => " ضمن تحليل قوى بورتر الخمس تحليل كلا من التهديد من القدرة التفاوضية للعملاء والتهديد من القدرة التفاوضية للموردين فقط على {$query} في {$location}
                                              يجب ان يكون النص عبارة عن اثنين div كبطاقات card مع اعطاء لون لكل card و margin-top:10px لكل بطاقة مع وضع padding داخلي للبطاقات وذكر العناصر الخاصة بالقسم بداخل البطاقة ك ul وان يكون لكل قسم ثلاث نقاط مع وضع العنوان في عنصر strong ثم الشرح مع شرح بسيط لكل نقطة وان يكون تنسيق css في داخل العناصر بدون بالطبع ساقوم اريد النص فقط كالصيغة التالية {$example_swot}"
            ],
            [
                'section_name' => 'competitor_analysis',
                'project_id' => $project->id,
                'user_id' => Auth::user()->id,
                'content' => "قم بتوفير تحليل مفصل للمنافسين لـ{$query} بما في ذلك المنافسين المحليين في {$location} والمنافسين العالميين:
                                                                قم بإدراج المنافسين الرئيسيين.
                                                                قم بتضمين حصتهم في السوق ونقاط قوتهم ونقاط ضعفهم ومواقعهم.
                                                                قم بمقارنة ميزات منتجاتهم وأسعارهم على ان يكون المنافسين المحليين في قسم والعالميين في قسم منفصل.                               
                                                                يجب أن يتكون النص من عدة نقاط كل نقطة في فقرة منفصلة، مع عنوان لكل نقطة ووضع 
                                                                <br> في نهاية كل فقرة  مع وضع العنوان الرئيسي في عنصر h3 والفقرة في عنصر p وان تبدا بالمنافسين العالميين ثم المنافسين المحليين"

            ],
            [
                'section_name' => 'industry_benchmarks_financial_1',
                'project_id' => $project->id,
                'user_id' => Auth::user()->id,
                'content' => "لفكرة {$query} قدم تحليل لمعايير الصناعة المالية تتضمن 5 معيارًا ماليًا كالتالي ،  
                                                                معدل نمو الإيرادات، هامش الربح الإجمالي، هامش الربح التشغيلي، صافي هامش الربح، تكلفة اكتساب العميل (CAC)،
                                                                العائد على الاستثمار (ROI)، التدفق النقدي الإيجابي، نسبة الدين إلى حقوق الملكية، النسبة الحالية
                                                                يجب ان تكون النتائج على شكل ارقام للفكرة مع شرح عن القيمة في كل نقطة  في نهاية كل فقرة مع وضع العنوان الرئيسي في عنصر strong ثم <br> ثم الفقرة في عنصر p مع الالتزام بالمثال التالي {$example_industry}"

            ],
            [
                'section_name' => 'industry_benchmarks_financial_2',
                'project_id' => $project->id,
                'user_id' => Auth::user()->id,
                'content' => "لفكرة {$query} قدم تحليل لمعايير الصناعة المالية تتضمن 5 معيارًا ماليًا كالتالي ،  
                                                                معدل نمو الإيرادات، هامش الربح الإجمالي، هامش الربح التشغيلي، صافي هامش الربح، تكلفة اكتساب العميل (CAC)،
                                                                يجب ان تكون النتائج على شكل ارقام للفكرة مع شرح عن القيمة في كل نقطة  مع وضع <br> في نهاية كل فقرة مع وضع العنوان الرئيسي في عنصر strong ثم <br> ثم الفقرة في عنصر p كالمثال التالي مع الالتزام بالمثال التالي  {$example_industry}"

            ],
            [
                'section_name' => 'industry_benchmarks_non_financial',
                'project_id' => $project->id,
                'user_id' => Auth::user()->id,
                'content' => " لفكرة {$query} قدم تحليل لمعايير الصناعة الغير مالية تتضمن 5 معيارًا غير مالي كالتالي:،  
                                                                رضا العملاء، والاحتفاظ بالموظفين، والحصة السوقية، والوعي بالعلامة التجارية، ومعدل فقدان العملاء، 
                                                                يجب ان تكون النتائج على شكل ارقام للفكرة مع شرح عن القيمة في كل نقطة في سطر في نهاية كل فقرة مع وضع العنوان الرئيسي في عنصر strong ثم <br> ثم الفقرة في عنصر p مع الالتزام بالمثال التالي {$example_industry} "

            ],
            [
                'section_name' => 'industry_benchmarks_non_financial_1',
                'project_id' => $project->id,
                'user_id' => Auth::user()->id,
                'content' => " لفكرة {$query} قدم تحليل لمعايير الصناعة الغير مالية تتضمن  4 معيارًا غير مالي كالتالي:،  
                                                               الوقت اللازم لدخول السوق، مؤشر صافي الترويج، انتاجية الموظفين، معدل ارجاع المنتجات.
                اذكر النقاط بدون وضع اي عنوان رئيسي مثل معايير الصناعة الغير مالية يجب ان تكون النتائج على شكل ارقام للفكرة مع شرح عن القيمة في كل نقطة في سطر في نهاية كل فقرة
                مع وضع العنوان الرئيسي في عنصر strong ثم <br> ثم الفقرة في عنصر p مع الالتزام بالمثال التالي {$example_industry} "

            ],
            [
                'section_name' => 'success_rate',
                'project_id' => $project->id,
                'user_id' => Auth::user()->id,
                'content' => "قم بتقدير معدل النجاح لـ {$query}، على شكل نسبة مئوية فقط مع وضعه في عنصر div واعطاءه  class='success_rate_number' مع كتابة فقرة بعدها من خمس سطور عن تحليل نسبة النجاح"

            ],
            [
                'section_name' => 'suggestion',
                'project_id' => $project->id,
                'user_id' => Auth::user()->id,
                'content' => "قدم نصائح  حول  كيفية التحقق من صحة فكرة المشروع مع الشرح 
                                                                   مع وضعها في عنوان نصائح حول كيفية التحقق من صحة فكرة المشروع وبعدها التوصيات.
                                                                 يجب أن يتكون النص من عدة نقاط كل نقطة في فقرة منفصلة، مع عنوان لكل نقطة ووضع 
                                      <br> في نهاية كل فقرة مع وضع العنوان الرئيسي في عنصر h3 والفقرة في عنصر p "

            ],
            [
                'section_name' => 'mvp_suggestion',
                'project_id' => $project->id,
                'user_id' => Auth::user()->id,
                'content' => "قدم توصيات حول كيفية معرفة الحد الادنى لتطبيق المشروع مع الشرح 
                                                                 مع وضعها في عنوان توصيات حول المشروع وبعدها التوصيات.
                                                                 يجب أن يتكون النص من عدة نقاط كل نقطة في فقرة منفصلة، مع عنوان لكل نقطة ووضع 
                                      <br> في نهاية كل فقرة  مع وضع العنوان الرئيسي في عنصر h3 والفقرة في عنصر p "

            ],


            [
                'section_name' => 'mvp_development',
                'project_id' => $project->id,
                'user_id' => Auth::user()->id,
                'content' => "حدد المراحل الرئيسية لتطوير المشروع لـ{$query}
                                                                في 10 خطوات مفصلة. قم بتضمين المراحل الرئيسية مثل:
                                                                أبحاث السوق وتحليل احتياجات المستخدم.
                                                                النمذجة الأولية للفكرة.
                                                                تطوير التطبيق للميزات الأساسية.
                                                                حلقات الاختبار والملاحظات مع قاعدة مستخدمين صغيرة.
                                                                يجب أن يتكون النص من عدة نقاط كل نقطة في فقرة منفصلة، مع عنوان لكل نقطة ووضع 
                                                                <br> في نهاية كل فقرة  مع وضع العنوان الرئيسي في عنصر h3 والفقرة في عنصر p"
            ],
            [
                'section_name' => 'final_recommendation',
                'project_id' => $project->id,
                'user_id' => Auth::user()->id,
                'content' => "تقديم قسم تفصيلي للتوصيات النهائية لفكرة {$idea} في {$location} لضمان نجاح الفكرة عبارة عن فقرة من 4-5 لسطور ايضا تقديم توصيات محددة لنجاح المشروع في قسم جديد مكون من 4-5 سطور 
                                                    ويجب أن تكون كل نقطة في فقرة منفصلة مكونة من عدة نقاط لكل فقرة، مع عنوان لكل نقطة ووضع <br> في نهاية كل فقرة  مع وضع العنوان الرئيسي في عنصر h3 والفقرة في عنصر p"
            ]
        ]);

        $sections = ReportSection::where('project_id', $project->id)->where('completed', false)->get()->toArray();

        $openAIResults = $this->openAIService->generateText($sections);
        $serpApiResults = $this->serpApiService->searchGoogleTrends(
            $idea,
            $location,
            $keywordsString
        );

        $googleResults = $this->googleSearchService->search(
            $idea,
            $location,
            $userId,
            $project->id,
            $keywordsString
        );
        $interestOverTime = $serpApiResults['interest_over_time'] ?? [];
        $timelineData = $interestOverTime['timeline_data'] ?? [];

        $this->serpApiService->storeInterestData($timelineData, $idea, $project->id, $userId);
        $interestData = $this->serpApiService->getInterestData($project->id);

        $interestOverTime = $serpApiResults['interest_over_time'] ?? [];
        $timelineData = $interestOverTime['timeline_data'] ?? [];

        $labels = [];
        $values = [];

        foreach ($timelineData as $dataPoint) {
            $labels[] = date('Y-m-d', $dataPoint['timestamp']);
            $values[] = $dataPoint['values'][0]['value'] ?? 0;
        }

        // $serpApiResults = Serpapi::where('project_id', $project->id)->get();
        $report_sections = ReportSection::where('project_id', $project->id)->get();
        $googleResults = Google::where('project_id', $project->id)->get();
        $interestData = $this->serpApiService->getInterestData($project->id);

        return view('projects.show', [
            'report_sections' => $report_sections,
            'googleResults' => $googleResults,
            'interestData' => $interestData,
            'labels' => json_encode($labels),
            'values' => json_encode($values),
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
