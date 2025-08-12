@extends('layouts.admin')

@section('title', 'Edit Content')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Edit {{ ucfirst(str_replace('_', ' ', $content->key)) }} Content</h1>
        <a href="{{ route('admin.content.index') }}" 
           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
            Back to Content
        </a>
    </div>

    <div class="bg-white shadow-sm rounded-lg">
        <form method="POST" action="{{ route('admin.content.update', $content->key) }}" class="space-y-6 p-6">
            @csrf
            @method('PUT')

            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title', $content->title) }}" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('title') border-red-300 @enderror">
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Optional title for this content section</p>
            </div>

            <div>
                <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                <textarea name="content" id="content" rows="10" 
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('content') border-red-300 @enderror">{{ old('content', $content->content) }}</textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">
                    Main content for this section. You can use HTML and markdown formatting.
                </p>
            </div>

            
            @if($content->key === 'hero')
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900">Hero Section Settings</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="meta_subtitle" class="block text-sm font-medium text-gray-700">Subtitle</label>
                            <input type="text" name="meta[subtitle]" id="meta_subtitle" 
                                   value="{{ old('meta.subtitle', $content->meta['subtitle'] ?? '') }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        
                        <div>
                            <label for="meta_cta_text" class="block text-sm font-medium text-gray-700">CTA Button Text</label>
                            <input type="text" name="meta[cta_text]" id="meta_cta_text" 
                                   value="{{ old('meta.cta_text', $content->meta['cta_text'] ?? 'View Projects') }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>
                    
                    <div>
                        <label for="meta_cta_url" class="block text-sm font-medium text-gray-700">CTA Button URL</label>
                        <input type="text" name="meta[cta_url]" id="meta_cta_url" 
                               value="{{ old('meta.cta_url', $content->meta['cta_url'] ?? '/projects') }}" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>
            @endif

            @if($content->key === 'stats')
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900">Statistics</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="meta_projects_count" class="block text-sm font-medium text-gray-700">Projects Completed</label>
                            <input type="number" name="meta[projects_count]" id="meta_projects_count" 
                                   value="{{ old('meta.projects_count', $content->meta['projects_count'] ?? '50') }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        
                        <div>
                            <label for="meta_clients_count" class="block text-sm font-medium text-gray-700">Happy Clients</label>
                            <input type="number" name="meta[clients_count]" id="meta_clients_count" 
                                   value="{{ old('meta.clients_count', $content->meta['clients_count'] ?? '25') }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="meta_experience_years" class="block text-sm font-medium text-gray-700">Years of Experience</label>
                            <input type="number" name="meta[experience_years]" id="meta_experience_years" 
                                   value="{{ old('meta.experience_years', $content->meta['experience_years'] ?? '5') }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        
                        <div>
                            <label for="meta_awards_count" class="block text-sm font-medium text-gray-700">Awards Won</label>
                            <input type="number" name="meta[awards_count]" id="meta_awards_count" 
                                   value="{{ old('meta.awards_count', $content->meta['awards_count'] ?? '10') }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>
                </div>
            @endif

            @if($content->key === 'skills')
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900">Skills Configuration</h3>
                    
                    <div>
                        <label for="meta_skills" class="block text-sm font-medium text-gray-700">Skills (one per line)</label>
                        <textarea name="meta[skills]" id="meta_skills" rows="6" 
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('meta.skills', isset($content->meta['skills']) ? implode("\n", $content->meta['skills']) : "Laravel\nPHP\n3ds Max\nBlender\nPhotoshop\nIllustrator") }}</textarea>
                        <p class="mt-1 text-sm text-gray-500">Enter each skill on a new line</p>
                    </div>
                </div>
            @endif

           
            @if($content->key === 'about_profile_summary')
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900">Profile Summary Settings</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="meta_image" class="block text-sm font-medium text-gray-700">Profile Image Path</label>
                            <input type="text" name="meta[image]" id="meta_image" 
                                   value="{{ old('meta.image', $content->meta['image'] ?? '/images/about/profile.jpg') }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <p class="mt-1 text-sm text-gray-500">Path to profile image (e.g., /images/about/profile.jpg)</p>
                        </div>
                        
                        <div>
                            <label for="meta_years_experience" class="block text-sm font-medium text-gray-700">Years of Experience</label>
                            <input type="number" name="meta[years_experience]" id="meta_years_experience" 
                                   value="{{ old('meta.years_experience', $content->meta['years_experience'] ?? '5') }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>
                    
                    <div>
                        <label for="meta_projects_completed" class="block text-sm font-medium text-gray-700">Projects Completed</label>
                        <input type="number" name="meta[projects_completed]" id="meta_projects_completed" 
                               value="{{ old('meta.projects_completed', $content->meta['projects_completed'] ?? '50') }}" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>
            @endif

          
            @if($content->key === 'about_skills')
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900">Skills & Technologies Configuration</h3>
                    
                    <div id="skills-categories">
                        @php
                            $categories = old('meta.categories', $content->meta['categories'] ?? [
                                [
                                    'name' => 'Web Development',
                                    'skills' => [
                                        ['name' => 'Laravel', 'level' => 90, 'icon' => 'laravel'],
                                        ['name' => 'PHP', 'level' => 85, 'icon' => 'php'],
                                        ['name' => 'JavaScript', 'level' => 80, 'icon' => 'javascript']
                                    ]
                                ]
                            ]);
                        @endphp
                        
                        @foreach($categories as $categoryIndex => $category)
                            <div class="border border-gray-200 rounded-lg p-4 category-item">
                                <div class="flex justify-between items-center mb-3">
                                    <h4 class="font-medium text-gray-900">Category {{ $categoryIndex + 1 }}</h4>
                                    <button type="button" class="text-red-600 hover:text-red-800 remove-category">Remove</button>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-gray-700">Category Name</label>
                                    <input type="text" name="meta[categories][{{ $categoryIndex }}][name]" 
                                           value="{{ $category['name'] ?? '' }}" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                
                                <div class="skills-list">
                                    @foreach($category['skills'] ?? [] as $skillIndex => $skill)
                                        <div class="grid grid-cols-4 gap-2 mb-2 skill-item">
                                            <input type="text" name="meta[categories][{{ $categoryIndex }}][skills][{{ $skillIndex }}][name]" 
                                                   placeholder="Skill name" value="{{ $skill['name'] ?? '' }}" 
                                                   class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                            <input type="number" name="meta[categories][{{ $categoryIndex }}][skills][{{ $skillIndex }}][level]" 
                                                  "
>
                                            <input type="text" name="meta[categori 
                                                   placeholde}" 
                                                   class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                          ton>
                    /div>
                                    @e
                                </div>
                                
                         
                  >
               
          
                

        Category
                    </button>
                </div>
            @endif

          
            @if($content->key === 'aboue')
                <div class="space-y-4">
           >
       
   >
             @php
               @endif     /div>
             <    </div>
               >
       /div     <         
          00">ing-blue-5s:rcu00 fo-blue-5ocus:borderow-sm fray-300 shadmd border-gunded-ull row-f"mt-1 block lass=      c                      
         '250') }}" ??ize']eta['file_st->m $contene',_siz'meta.fileue="{{ old(     val                              size" 
_file_ id="metaile_size]"meta[f" name="numberut type="inp           <              /label>
   ze (KB)<">File Siay-700m text-grnt-mediufo-sm "block textss= clasize"_file_"metael for=  <lab                       v>
   di     <                 
               
           </div>                    0">
    ue-50cus:ring-bl00 foe-5s:border-bluocuhadow-sm f-300 saymd border-grull rounded-ock w-f"mt-1 blass=       cl                  
          }}" d')) ? date('Y-m-'] ?_updatedta['lastt->me$contenpdated', last_u('meta.e="{{ oldalu           v                       
 updated" ta_last_id="meted]" st_updameta[late" name="ut type="da    <inp                        el>
ab</lLast Updateday-700">um text-grsm font-mediock text-"bl class=pdated"ta_last_umeel for="lab       <           
          v>     <di           
        ">2 gap-4d:grid-cols-s-1 mid-colgrid griv class="  <d                          
          div>
           </         </p>
  ume the resdser downloahen usme w">Filena-500rayxt-sm text-g-1 teass="mtcl <p                    500">
    ring-blue-cus:lue-500 fo:border-bm focus0 shadow-s-gray-30orderd-md bde-full rounblock w"mt-1 ss=la    c                           ') }}" 
pdfan-Resume.KhAziz-name'] ?? 'fileesume_ta['rmeontent->lename', $ca.resume_fi{ old('metalue="{   v                    " 
        lename_resume_fieta" id="mname]filemeta[resume_ name=""text"<input type=                       l>
 me</labenload Filenaow>Day-700"m text-grfont-mediut-sm block texclass="_filename" sume"meta_relabel for=    <              div>
         <          
                   
        >iv    </d         >
       e.pdf)</pnts/resumc/docume(e.g., publiin storage file esume ">Path to rt-gray-500t-sm tex1 texs="mt-p clas     <            ">
       500-blue-s:ring focuer-blue-500cus:bordshadow-sm foay-300 d border-grnded-mw-full rou block s="mt-1  clas                         
     }}"me.pdf') an-resuaziz-khents/ocum? 'public/dpath'] ?['resume_tat->meten', $conume_pathres old('meta.alue="{{          v                     
 th"ume_pa="meta_res" idath]eta[resume_p" name="mpe="text   <input ty                   /label>
  e Path<il">Resume Fxt-gray-700m teiusm font-medt-ock texclass="ble_path" umta_res="me<label for                     div>
            <    
                          ings</h3>
 ume SettResray-900">ext-g-medium txt-lg font"teh3 class=         <       ">
    "space-y-4div class=          <)
      _resume'about->key === 'tent   @if($con         >
 Settings --ut Resume    <!-- Abo       

 if        @end
         </div>        /div>
            <      0">
     -blue-50:ring500 focusorder-blue-ocus:b-sm fy-300 shadow-grabordered-md roundll  w-fu"mt-1 blocklass=        c                      }}" 
  Turkish') Urdu,  : 'English,])nguages'>meta['la', $content-(', ? implodenguages']) t->meta['lat($contenes', isseagangu('meta.l"{{ old    value=                           
 s"ta_languages]" id="meta[language" name="metexttype="input          <            el>
   )</labseparatedcomma nguages (La00">y-7 text-gra-medium font text-smblocks="uages" clasanga_letbel for="m         <la           
    v> <di                  
                 /div>
          <         div>
       </            
          ue-500">:ring-blocus00 forder-blue-5us:b fochadow-sm00 sorder-gray-3nded-md bl rouck w-fulmt-1 blo="class                             " 
      ani') }}st?? 'Pakity'] nationalitent->meta['ality', $conmeta.natione="{{ old('      valu                            
 onality" a_natiet"md=" iationality]="meta[nt" name="text type     <inpu                       </label>
nalityNatio700">ay-um text-grnt-medixt-sm fo telock class="bity"eta_nationalbel for="m <la                  
         div>  <                          
                   iv>
       </d               
   -500">:ring-bluefocus500 rder-blue- focus:bow-smshadoy-300 r-graded-md bordel rounk w-ful-1 blocclass="mt                                  " 
 }?? '') }ate'] irth_da['bt->metnten_date', $cobirtha. old('metvalue="{{                                   
 te"h_dairtmeta_be]" id="th_dat[bir"metaname="date" put type=   <in                      l>
   beth Date</laBirray-700">ium text-gont-medck text-sm f class="bloth_date"r="meta_birbel fo<la                        iv>
            <d         ">
       -4ls-2 gaprid-cocols-1 md:grid-"grid g <div class=            
                       
    v>di    </                
      </div>                  e-500">
ing-blufocus:rblue-500 border-ocus:m fow-shady-300 sder-graed-md borl round block w-ful-1mtass="        cl                         }" 
  akistan') }Karachi, Pon'] ?? 'timeta['locat->$contenion', ocateta.l"{{ old('m    value=                           on" 
    _locati"meta id=ation]"locme="meta[ext" naype="t t      <input                    
  on</label>">Locati00text-gray-7dium -sm font-mext"block ten" class=catio"meta_loabel for=   <l                      v>
        <di              
                        v>
      </di                     ">
  g-blue-500:rinue-500 focusblr-us:bordesm foc00 shadow-ray-3er-grdnded-md boou rblock w-full="mt-1 class                              }}" 
     mber]') '[phone_nu'phone'] ?? ta[->metente', $conhon.pmetad('ue="{{ ol       val                 
            hone""meta_p=idne]" a[pho name="mete="text" typutnp         <i              
     </label>00">Phone-7ayum text-gront-medism f"block text-class=one" r="meta_phbel fo<la                        >
        <div                    4">
-2 gap-md:grid-colsgrid-cols-1 lass="grid     <div c      
                         v>
          </di            </div>
                          
 e-500">ing-blu00 focus:rder-blue-5 focus:borhadow-sm300 sray-er-ged-md bord-full roundock w-1 blass="mt      cl                           }" 
  [email]') }? 'il'] ?>meta['emantent-l', $co('meta.emaild="{{ o       value                         l" 
   ai"meta_em]" id=ta[emailme="meil" nat type="ema      <inpu                    >
  /label">Email<700ray-ium text-gm font-medk text-s"bloclass=ta_email" cr="mel foabe      <l                       <div>
             
                                  /div>
  <              
        00">-5ue-blocus:ringe-500 fborder-bluw-sm focus:00 shadorder-gray-3-md bodedounl r block w-ful"mt-1ss=la         c                          an') }}" 
?? 'Aziz Khll_name'] >meta['fucontent-, $name''meta.full_{ old("{  value=                                 " 
ull_name_fid="metal_name]" ="meta[ful" name type="textut  <inp                      label>
    ame</700">Full Ny--graedium textsm font-mxt-k telass="bloc_name" cta_full="me<label for                         div>
         <             
     ">ols-2 gap-41 md:grid-cd-cols-rid grilass="g      <div c                   
             
  ation</h3>form>Personal In-900"xt-grayedium te-mlg fonttext-lass="   <h3 c                 -y-4">
s="spacelasv c        <di    
    ')ersonal_info= 'about_p==ontent->key ($c      @if-->
      s Settingsonal Info out PerAb   <!-- 
         
f      @endiv>
      di          </
      /button>  <                  on
tificatiCerdd      A                 ium">
   font-med-md text-smed4 py-2 roundhite px-n-700 text-wr:bg-gree0 hoven-60bg-greess="ion" claificatd="add-cert" ie="buttonbutton typ      <                 
            iv>
        </d             
    achore   @endf                        </div>
                   
            </div>               
           </div>                                500">
    lue-cus:ring-b0 foder-blue-50s:borcu foshadow-smgray-300 r-borderounded-md  w-full t-1 block  class="m                                            '' }}" 
  ?? ert['url']alue="{{ $c       v                                      " 
   }}][url]ertIndex{ $cs][{ionattificta[cer name="meurl"t type="     <inpu                                  el>
 labn URL</ioicaterif">Vxt-gray-700t-medium tesm fonck text-ss="bloclal abe<l                                     <div>
                                
            </div>                             -500">
  us:ring-blueoclue-500 forder-b-sm focus:bhadow-300 srder-gray bounded-mdro-full lock wmt-1 b   class="                                            ' }}" 
l_id'] ?? 'dentia $cert['cre value="{{                                             
 d]" ial_i}][credentndex }{{ $certIcations][tifimeta[cer" name="pe="text  <input ty                                el>
      ial ID</lab00">Credentay-7ext-grmedium tm font-t-sock texl class="bllabe      <                            
         <div>                             v>
    /di <                                  ">
 blue-500ring-us:blue-500 focder-us:bor-sm focadow00 shgray-3md border-unded-k w-full robloc1 ="mt-class                                            
    }"te'] ?? '' }$cert['da"{{     value=                                       
    te]" dex }}][daInrt{ $ceons][{ficatita[certiname="me"text" nput type=         <i                              l>
 abee</laty-700">Dt-graedium texxt-sm font-ms="block teel clas   <lab                              
       iv>      <d                            p-4">
  s-3 gamd:grid-colgrid-cols-1 ass="grid   <div cl                             
                                
 div>       </                        
 v>di</                              ">
      lue-500ng-bfocus:ri-500 order-blueus:bocsm fhadow-0 s-30rder-graymd boll rounded-k w-fu"mt-1 blocclass=                                    
           ? '' }}" ['issuer'] ?{ $certue="{        val                                     suer]" 
  }}][is $certIndex [{{ons]ificatiertmeta[c" name="type="text<input                                   
      er</label>00">Issuay-7dium text-gront-mem f text-sss="blockabel cla          <l                                 <div>
                             
    </div>                                500">
    e-bluing-s:rcu-blue-500 foerfocus:borddow-sm -300 shaorder-graymd bed-w-full round1 block "mt-ss=  cla                                      
       }}" '' 'name'] ?? t[{ $cer  value="{                                            " 
 ][name]ertIndex }}[{{ $cfications]certime="meta["text" nanput type=    <i                                 abel>
   tion Name</licaif0">Certgray-70ium text-med font-t-sm"block texs=el clas <lab                                       <div>
                                 ">
   34 mb- gap-:grid-cols-2-cols-1 mdridid glass="gr c<div                         
                                     
    </div>                             tton>
 </bumoveon">Reertificati00 remove-c-red-8ver:text600 ho-red-text="lass c="button" typebutton  <                                 
 }}</h4>rtIndex + 1 $cetion {{ ">Certificaray-900t-g-medium texlass="font       <h4 c                       ">
      r mb-3entes-ceen itembetwlex justify-"fass=v cl  <di                    
          em">-itertificationd-lg p-4 cde00 rounrder-gray-2er boordclass="b       <div                     rt)
 $ce => ndextIas $cerfications reach($certifo    @              
                         hp
       @endp                     ]);
                        
      ]                            > ''
       'url' =                                d' => '',
dential_i     'cre                             23',
   '20=>date'         '                   
         vel',r' => 'Larassue       'i                            r',
  Developeertifiedavel CLar' => '     'name                               [
                             
   s'] ?? [ationta['certifictent->metions', $conficartiold('meta.cefications = ti$cer                       
     p       @ph           
      ons-list">ati"certificiv id=     <d             
                    >
  tion</h3rafiguons Cficationtiay-900">Certext-grt-medium t-lg fon"texss=la  <h3 c                  
y-4">ce-"spaclass=    <div           tions')
  ficaout_certikey === 'ab($content->       @if    ings -->
  Settfications Certi  <!-- About
          endif
     @    
   >      </div      ton>
    but  </               ation
   d Educ       Ad            
     um">font-medim d text-s rounded-mte px-4 py-2t-whireen-700 texover:bg-g00 hbg-green-6="lass" conucati id="add-edtton" type="buton        <but                
              div>
    </                  dforeach
      @en                   </div>
                          v>
 di        </                >
        extarea '' }}</t??n'] ['descriptio">{{ $edu-blue-500focus:ring0 der-blue-50focus:bor shadow-sm y-300-graderded-md borll rounck w-fulo="mt-1 bss  cla                                       " 
     " rows="2on]criptidex }}][des][{{ $eduIneducationname="meta[a     <textare                               n</label>
 Descriptioy-700">-graxtedium tem font-mt-sock texss="bl  <label cla                              div>
        <                        
                              
      div>    </                    
        div>         </                  >
         -500"ring-blue0 focus:der-blue-50s:borm focuow-s shadray-300-md border-gull rounded1 block w-fclass="mt-                                      
          '' }}"a'] ?? du['gp $ee="{{ valu                                              
 x }}][gpa]"[{{ $eduInde[education]me="metaext" nae="t <input typ                                       )</label>
nal">GPA (optio0ext-gray-70ium t-medtext-sm fontlock  class="b   <label                               >
              <div                     v>
           </di                            ">
    ng-blue-500ri00 focus:der-blue-5orcus:bdow-sm fo-300 sharder-grayunded-md bow-full rolock 1 bass="mt-cl                                         }" 
       ?? '' }u['period']e="{{ $ed valu                                          
     iod]"er[pdex }}]][{{ $eduIneducationa[" name="metpe="text   <input ty                            
         label></">Periodext-gray-700dium tont-me text-sm fblockss="el cla     <lab                                 div>
             <                    >
     /div      <                         00">
     ng-blue-5rie-500 focus:der-bluborcus:dow-sm fo shay-300rder-graed-md boull round1 block w-fmt-lass="           c                                " 
     }}'] ?? ''cation{ $edu['lo"{lue=        va                                     n]" 
  catio}}][loeduIndex ion][{{ $[educat"meta" name=ype="textt t      <inpu                                  n</label>
">Locatio00ray-7text-gum t-meditext-sm fons="block l clas  <labe                                  >
          <div                            >
  -3"mbls-3 gap-4 -co-1 md:gridid-colsd gr"gri<div class=                       
                                     </div>
                          
            </div>                                 ">
 ng-blue-500ri0 focus:lue-50s:border-bow-sm focuhadr-gray-300 sded-md borde-full rounmt-1 block w    class="                                      
     '' }}" ution'] ?? nstitedu['ialue="{{ $      v                                 " 
        ion]nstitutuIndex }}][iedcation][{{ $"meta[eduxt" name="tet type=npu<i                                      abel>
  itution</l>Instgray-700"ium text- font-medsm"block text-=el classab         <l                       
        <div>                                    
div>         </                        >
   blue-500"g-cus:rinblue-500 foer-ocus:bord fshadow-smy-300 border-gramd ded- w-full roun"mt-1 blockclass=                                              }}" 
  ''gree'] ?? edu['deue="{{ $val                                            
   ee]" gr][de}}{ $eduIndex ][{ucationeta[ede="mname="text" t typ  <inpu                               
       /label>Degree<ray-700">xt-gnt-medium tetext-sm folock ="b class<label                                             <div>
                           ">
    -4 mb-3ls-2 gapd-cols-1 md:gricoid grid-lass="gr<div c                                      
                      </div>
                                    utton>
>Remove</bn"catioremove-edut-red-800 r:tex-600 hove"text-redass=tton" cl"buutton type=    <b                         4>
       1 }}</h + ndexion {{ $eduIducatgray-900">E text--mediumss="font4 cla    <h                         ">
       r mb-3s-cente itemfy-betweenustis="flex jas    <div cl                    >
        "itemcation-d-lg p-4 edude-200 rouner-grayder bord class="bor<div                   
         $edu)ndex => duIcation as $e($educh  @forea                      
                     php
   nd       @e        
               ]);                          ]
                     
       a' => ''         'gp                    ',
       tion' => '    'descrip                           9',
     '2015 - 201>   'period' =                                  
Country',ty, ion' => 'Ciocat       'l                    
         y Name',sitivertion' => 'Un 'institu                                 ce',
  mputer Scien of Co'Bachelor'degree' =>                                       [
                            ?? [
   cation']['eduent->metacontducation', $'meta.eion = old(ucat    $ed                          @php
                    st">
  -liond="educativ i <di                         
             
 ion</h3>nfigurat Coion">Educaty-900t-graium texedg font-mext-ls="t clas         <h3       4">
    -y-lass="spacev c  <di            
  n')catio 'about_edu>key ===$content-    @if(
        ->ings -Settation - About Educ!-          <  f

 @endi        iv>
   /d    <          
    </button>                perience
      Add Ex               >
     ont-medium"d text-sm fnded-mouy-2 rwhite px-4 p0 text-reen-70over:bg-geen-600 h="bg-gr" classperienced="add-exn" i"butto type=ton    <but             
                      >
      </div              foreach
        @end                </div>
                       
          </div>                       
     00">:ring-blue-5ue-500 focusbl:border--sm focus shadow-gray-300ed-md borderndroul w-ful block -1mt"  class=                                         " 
]) : '' }}chnologies'rience['te', $expemplode(', ies']) ? inologience['techexperisset($ue="{{         val                                 s]" 
  gie}][technolo $expIndex }[{{e]timeline="meta["text" nam=ype<input t                                   abel>
 parated)</lse (comma ogies>Technol-700" text-grayont-mediumsm ft-lock tex class="b<label                         
                 <div>                        
                                </div>
                                 xtarea>
 /te}<s']) : '' }entevemce['achiien", $exper\node("mpl ? its'])'achievemenperience[sset($ex">{{ i00ring-blue-5-500 focus::border-blue focusdow-smharay-300 sborder-gd ded-m w-full roun"mt-1 blockss=       cla                                       ="3" 
ents]" rows][achievem$expIndex }}[{{ ine]timelme="meta[naarea   <text                                
  </label> line)per (one ements700">Achievy-xt-gram te font-mediuxt-sm="block te class    <label                          
      -3">ass="mbiv cl        <d                             
                          >
 </div                              tarea>
  ' }}</tex '??ion'] e['descriptxperienc{ $ee-500">{ng-blucus:riue-500 for-blfocus:bordew-sm 300 shadoray-border-grounded-md ll  w-fu blockmt-1 class="                                        " 
     ows="3on]" rti }}][descripIndexine][{{ $exptimela["metea name=    <textar                           
     l>ion</labeDescript700">y-m text-gradiufont-mesm ck text-blo"ass=bel cl   <la                                 3">
"mb-s=div clas       <                 
                                    div>
              </                iv>
      </d                                  ">
  -500-blueus:ringocblue-500 focus:border--sm f-300 shadowr-grayded-md borde w-full roun-1 blockmt"ass=    cl                                   " 
        '] ?? '' }}e['periodienc"{{ $exper    value=                                       d]" 
    ][perio}} $expIndex eline][{{timame="meta[ n"text"ut type=        <inp                            abel>
    eriod</lgray-700">Pum text-nt-meditext-sm fos="block lasel c <lab                                iv>
              <d                          </div>
                                 
      lue-500">ng-bcus:riue-500 forder-blcus:bofom -s shadow300der-gray- bornded-md roulock w-full"mt-1 b   class=                                     
        ?? '' }}"'location'] rience[$expealue="{{    v                                          " 
  location] }}][ $expIndexmeline][{{a[ti"met=xt" name"tetype=    <input                           
          label>cation</ray-700">Loext-gum t-medim font text-slass="blockel c      <lab                                 
 <div>                                   mb-3">
  ls-2 gap-4-cos-1 md:gridid grid-colss="grdiv cla           <                              
                        </div>
                         
      </div>                          
          blue-500">ocus:ring-ue-500 forder-blm focus:badow-sy-300 shder-graunded-md borrolock w-full -1 bclass="mt                                          }" 
      '' }??pany'] erience['com"{{ $expvalue=                                              
  [company]"expIndex }}]{{ $line][a[time"metame="text" ninput type=        <                               
 abel>y</lpan>Com"gray-700xt-nt-medium te text-sm foass="blockabel cl        <l                               <div>
                                     </div>
                                
    ">500blue-:ring-e-500 focuser-blu focus:bordw-smdo-300 shaayr-grborde rounded-md ock w-fullbls="mt-1 las  c                                            
 ' }}" ? 'osition'] ?['perience{{ $exp="   value                                       
      [position]" }}]xpIndex $eimeline][{{e="meta[ttext" namut type="        <inp                              abel>
  tion</l">Posiay-700um text-grmedim font-ext-s"block tlass=   <label c                              v>
       di     <                               mb-3">
ap-4 id-cols-2 gls-1 md:grrid grid-co"giv class=  <d                                    
                         >
 iv       </d                   >
      ove</button">Remxperienceve-e800 remo:text-red-ver600 ho"text-red-s=on" clas"button type=tt<bu                              4>
       + 1 }}</hdexpIn{ $exrience {0">Expe-gray-90edium text="font-m <h4 class                                  r mb-3">
 nte-ceen itemsify-betwelex justs="f  <div clas                              
">temce-irien p-4 expelg200 rounded-der-gray-order bor"b class=   <div                       e)
   $experiencexpIndex =>e as $melin@foreach($ti                            
              dphp
               @en           ]);
                       
              ]                 
           []' =>iesnolog  'tech                          
         => [],hievements'    'ac                            > '',
    on' =scripti'de                              
      ,esent'Pr => '2022 - period'      '                         ',
     emoten' => 'Rtio'loca                            ,
        e'Freelanc' => 'company  '                               er',
   Web Developist & ior 3D Artenion' => 'S     'posit                            
    [                          
     ne'] ?? [ta['timelint->mene', $contelita.time old('mene =meli      $ti                      timeline"ce-perien="exdiv id        <                      h3on</guratice Confi Experien900">Workxt-gray-dium tet-lg font-metex="<h3 class         perienct_ex      Add           um">ont-meditext-sm fmd d-py-2 rounde4 x-t-white p700 texer:bg-green-ov hgreen-600 class="bg-tegory"dd-ca" id="auttone="byp <button t                           </div>      chorea     @endf          </div    tton></bullSkidd >A-skill"add800 e-xt-bluer:te0 hovlue-60-2 text-bs="mtn" clas"button type=    <butto   oreachndf           <         emove</but-skill">Remove00 r-8r:text-red0 hove-60"text-redton" class=type="but    <button               ] ?? '' }['icon'kill $s{{lue="" vaamer="Icon n}][icon]"illIndex }[{{ $sk][skills]goryIndex }}s][{{ $cateeue-500"-bl focus:ring500border-blue-sm focus:w- shadoer-gray-300ordrounded-md b  class="                                                 x="100="1" ma'' }}" min] ?? ['level'"{{ $skillue=" val-100)el (1der="Levlacehol p

            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.content.index') }}" 
                   class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md text-sm font-medium">
                    Update Content
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-resize textarea
    const textarea = document.getElementById('content');
    if (textarea) {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        });
    }
});
</script>
@endsection