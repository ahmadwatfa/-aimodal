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
                'content' => "على شكل JSON صالح فقط بدون أي نص إضافي أو تعليقات، قم بكتابة **المشاكل والحلول التي تواجه العملاء في {$query} في {$location}.  
        
                                     **المشاكل:**  
                             
                                     - اجعل المشاكل مترابطة وتعكس التحديات الحقيقية التي يواجهها العملاء.  
        
                                     **الحلول:**  
                                     - ضع **4 حلول رئيسية** بحيث يكون كل حل متوافقًا مع المشكلة المقابلة له.  
                                     -  لكل حل، مع وصف مختصر يوضح كيف يعالج المشكلة المذكورة.  
                         يجب أن تكون المخرجات باللغة {$lang}

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
                                 يجب أن تكون المخرجات باللغة {$lang}

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
                 يجب أن تكون المخرجات باللغة {$lang}

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
                                 يجب أن تكون المخرجات باللغة {$lang}

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
                                 يجب أن تكون المخرجات باللغة {$lang}

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
                                 يجب أن تكون المخرجات باللغة {$lang}

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
                                 يجب أن تكون المخرجات باللغة {$lang}

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
                                 يجب أن تكون المخرجات باللغة {$lang}

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
                                 يجب أن تكون المخرجات باللغة {$lang}

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
                                 يجب أن تكون المخرجات باللغة {$lang}

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
                                 يجب أن تكون المخرجات باللغة {$lang}

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
            ],[
        'section_name' => 'problems_and_opportunities',
        'project_id' => $project->id,
        'user_id' => Auth::user()->id,
        'content' => "على شكل JSON، قم بكتابة **المشاكل والفرص** المتعلقة بفكرة {$query} في {$location}.
                 ضع **5 فرص** بحيث يكون كل فرصة متوافقًا مع المشكلة المقابلة لها.  
                 يجب أن تكون المخرجات باللغة {$lang}
              **المخرجات المتوقعة:**
              {
                \"problems\": [
                  \"المشكلة 1: [وصف المشكلة الأولى]\",
                  \"المشكلة 2: [وصف المشكلة الثانية]\",
                  \"المشكلة 3: [وصف المشكلة الثالثة]\"
                  \"المشكلة 4: [وصف المشكلة الرابعة]\"
                  \"المشكلة 5: [وصف المشكلة الخامسة]\"
                ],
                \"opportunities\": [
                  \"الفرصة 1: [وصف الفرصة الأولى]\",
                  \"الفرصة 2: [وصف الفرصة الثانية]\",
                  \"الفرصة 3: [وصف الفرصة الثالثة]\"
                  \"الفرصة4: [وصف الفرصة الرابعة]\"
                  \"الفرصة 5: [وصف الفرصة الخامسة]\"
                ]
              }"
      ],
      [
        'section_name' => 'solutions_and_opportunities',
        'project_id' => $project->id,
        'user_id' => Auth::user()->id,
        'content' => "على شكل JSON، قم بكتابة **الحلول والفرص المتاحة** لفكرة {$query} في {$location}.
                   ضع **5 فرص** بحيث يكون كل فرصة متوافقًا مع الحل المقابلة لها.  
                 يجب أن تكون المخرجات باللغة {$lang}

              **المخرجات المتوقعة:**
              {
                \"solutions\": [
                  \"الحل 1: [وصف الحل الأول]\",
                  \"الحل 2: [وصف الحل الثاني]\",
                  \"الحل 3: [وصف الحل الثالث]\"
                  \"الحل 4: [وصف الحل الرابعة]\"
                  \"الحل 5: [وصف الحل الخامسة]\"
                ],
                \"opportunities\": [
                  \"الفرصة 1: [وصف الفرصة الأولى]\",
                  \"الفرصة 2: [وصف الفرصة الثانية]\",
                  \"الفرصة 3: [وصف الفرصة الثالثة]\"
                  \"الفرصة 4: [وصف الفرصة الرابعة]\"
                  \"الفرصة 5: [وصف الفرصة الخامسة]\"
                ]
              }"
      ],
      [
        'section_name' => 'competitive_advantage',
        'project_id' => $project->id,
        'user_id' => Auth::user()->id,
        'content' => "على شكل JSON، قم بكتابة **المزايا التنافسية** لفكرة {$query} في {$location}.
                               يجب أن تكون المخرجات باللغة {$lang}

              **المخرجات المتوقعة:**
              {
                \"competitive_advantage\": [
                  \"الميزة 1: [وصف الميزة الأولى]\",
                  \"الميزة 2: [وصف الميزة الثانية]\",
                  \"الميزة 3: [وصف الميزة الثالثة]\"
                  \"الميزة 4: [وصف الميزة الرابعة]\"
                  \"الميزة5: [وصف الميزة الخامسة]\"
                ]
              }"
      ],
      [
        'section_name' => 'target_audience',
        'project_id' => $project->id,
        'user_id' => Auth::user()->id,
        'content' => "على شكل JSON، قم بكتابة **الفئات المستهدفة** لفكرة {$query} في {$location}.
                               يجب أن تكون المخرجات باللغة {$lang}

              **المخرجات المتوقعة:**
              {
                \"target_audience\": [
                  \"الفئة 1: [وصف الفئة الأولى]\",
                  \"الفئة 2: [وصف الفئة الثانية]\",
                  \"الفئة 3: [وصف الفئة الثالثة]\"
                  \"الفئة 4: [وصف الفئة الرابعة]\"
                  \"الفئة 5: [وصف الفئة الخامسة]\"
                ]
              }"
      ],
      [
        'section_name' => 'target_market',
        'project_id' => $project->id,
        'user_id' => Auth::user()->id,
        'content' => "على شكل JSON، قم بكتابة **حجم السوق المستهدف** لفكرة {$query} في {$location}،
         مع تضمين **حجم السوق الإجمالي (TAM)**، **حجم السوق المتاح (SAM)**، و **حجم السوق القابل للتنفيذ (SOM)**.
                 يجب أن تكون المخرجات باللغة {$lang}

          **المخرجات المتوقعة:**
          {
              \"target_market\": [
                  \"TAM : [حجم السوق الإجمالي بالارقام]\", 
                  \"SAM : [حجم السوق المتاح بالارقام]\",
                  \"SOM : [حجم السوق القابل للتنفيذ بالارقام]\"
              ]
          }"
      ],
      [
        'section_name' => 'competitors',
        'project_id' => $project->id,
        'user_id' => Auth::user()->id,
        'content' => "على شكل JSON، قم بكتابة **المنافسين الرئيسيين** لفكرة {$query} في {$location}.
                  كتابة 4 معايير للمنافسة بين الفكرة المطروحة والمنافسين الموجودين
                                   يجب أن تكون المخرجات باللغة {$lang}

              **المخرجات المتوقعة:**
              {
                \"competitors\": [
                  \"المنافس 1\",
                  \"المنافس 2\",
                  \"المنافس 3\"
                  \"المنافس 4\"
                ]
                \"competition_standard\": [
                  \"المعيار الاول 1\",
                  \"المعيار الثاني 2\",
                  \"المعيار الثالث 3\",
                  \"المعيار الرابع 4\"
                ]
              }"
      ],
      [
        'section_name' => 'future_revenues',
        'project_id' => $project->id,
        'user_id' => Auth::user()->id,
        'content' => "على شكل JSON، قم بكتابة **الإيرادات المستقبلية المتوقعة على شكل ارقام مالية تقريبية متوقعة** لفكرة {$query} في {$location}.
                               يجب أن تكون المخرجات باللغة {$lang} وبدون مقدمة او تعقيب فقط ارقام مالية

              **المخرجات المتوقعة:**
              {
                \"future_revenues\": [
                  \"الإيراد 1\",
                  \"الإيراد 2\",
                  \"الإيراد 3\",
                  \"الإيراد 4\",
                  \"الإيراد 5\",
                  \"الإيراد 6\",
              
                ]
              }"
      ],
      [
        'section_name' => 'investment',
        'project_id' => $project->id,
        'user_id' => Auth::user()->id,
        'content' => "على شكل JSON، قم بكتابة تفاصيل **الاستثمار** المطلوب لفكرة {$query} في {$location} 
                      بدون مقدمة او تعقيب فقط على شكل ارقام مالية.
                      ركز على ان تكون الارقام منطقية وقابلة للتنفيذ
                         يجب أن تكون المخرجات باللغة {$lang}

                 \n\n{
                  \"company_valuation\": \"[قيمة الشركة]\",
                  \"required_investment\": \"[المبلغ المطلوب للاستثمار]\",
                  \"equity_offered\": \"[النسبة المعروضة للاستثمار]\"
                }
        على شكل JSON، ثم قم بكتابة **كيفية استخدام الاستثمار** وقيمة كل بند لفكرة {$query} في {$location}.
        ركز  على ان يكون مجموع استخدام الاستثمار مساوي لقيمة الاستثمار المطلوب
                         يجب أن تكون المخرجات باللغة {$lang}

        \n\n{
              \"investment_usage\": [
                  {\"البند\": \"[التفاصيل]\", \"قيمة الاستثمار\": \"[المبلغ]\"},
                  {\"البند\": \"[التفاصيل]\", \"قيمة الاستثمار\": \"[المبلغ]\"}
              ]
            }"
      ],
      [
        'section_name' => 'team_members',
        'project_id' => $project->id,
        'user_id' => Auth::user()->id,
        'content' => "على شكل JSON، قم بكتابة **أعضاء الفريق** لفكرة {$query} في {$location}.
                         يجب أن تكون المخرجات باللغة {$lang}

             'team_members' => [
            [
                'name' => 'العضو 1',
                'job_title' => '[المسمى الوظيفي]',
                'brief_introduction' => ' مقدمة قصيرة عن العضو 1 في حدود 50 حرف'
            ],
            [
                'name' => 'العضو 2',
                'job_title' => '[المسمى الوظيفي]',
                'brief_introduction' => ' مقدمة قصيرة عن العضو 2 في حدود 50 حرف'
            ]
        ]"
      ],
      [
        'section_name' => 'timeline',
        'project_id' => $project->id,
        'user_id' => Auth::user()->id,
        'content' => "على شكل JSON، قم بكتابة **الجدول الزمني** لفكرة {$query} في {$location}، بحيث يتضمن كل مرحلة: بداية المرحلة، عنوانها، ووصفها.\n\n{
                         يجب أن تكون المخرجات باللغة {$lang}
      
        \"timeline\": [
                  {
                      \"بداية المرحلة\": \"[التاريخ]\",
                      \"عنوان المرحلة\": \"[العنوان]\",
                      \"وصف المرحلة\": \"[التفاصيل]\"
                  },
                  {
                      \"بداية المرحلة\": \"[التاريخ]\",
                      \"عنوان المرحلة\": \"[العنوان]\",
                      \"وصف المرحلة\": \"[التفاصيل]\"
                  }
                  {
                      \"بداية المرحلة\": \"[التاريخ]\",
                      \"عنوان المرحلة\": \"[العنوان]\",
                      \"وصف المرحلة\": \"[التفاصيل]\"
                  }
                  {
                      \"بداية المرحلة\": \"[التاريخ]\",
                      \"عنوان المرحلة\": \"[العنوان]\",
                      \"وصف المرحلة\": \"[التفاصيل]\"
                  }
              ]
            }"
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
