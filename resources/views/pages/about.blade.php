@extends('layouts.app')

@section('content')
    <x-page-header 
        title="{{ $pageTitle['title'] ?? 'About ' . ($siteBranding['title'] ?? 'Aziz Khan') }}"
        description="{{ $pageTitle['content'] ?? '2D/3D Artist & Web Developer passionate about creating digital experiences and innovative solutions.' }}"
        subtitle="{{ $pageTitle['meta']['subtitle'] ?? null }}">


        <div class="bg-white rounded-lg shadow-soft p-8 mb-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">{{ $profileSummary['title'] }}</h2>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        {{ $profileSummary['content'] }}
                    </p>

                    @if (isset($profileSummary['meta']['years_experience']) || isset($profileSummary['meta']['projects_completed']))
                        <div class="grid grid-cols-2 gap-6 mb-8">
                            @if (isset($profileSummary['meta']['years_experience']))
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-primary-600 mb-2">
                                        {{ $profileSummary['meta']['years_experience'] }}+</div>
                                    <div class="text-gray-600">Years Experience</div>
                                </div>
                            @endif

                            @if (isset($profileSummary['meta']['projects_completed']))
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-primary-600 mb-2">
                                        {{ $profileSummary['meta']['projects_completed'] }}+</div>
                                    <div class="text-gray-600">Projects Completed</div>
                                </div>
                            @endif
                        </div>
                    @endif

                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('resume.download') }}"
                            class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-md font-medium transition-colors duration-200 inline-flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            Download Resume
                        </a>
                        <a href="{{ route('contact') }}"
                            class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-md font-medium transition-colors duration-200">
                            Get In Touch
                        </a>
                    </div>
                </div>

                <div class="relative">
                    @if (isset($profileSummary['meta']['image']))
                        <img src="{{ $profileSummary['meta']['image'] }}" alt="{{ $siteBranding['title'] ?? 'Aziz Khan' }} Profile"
                            class="w-full h-96 object-cover rounded-2xl shadow-lg">
                    @else
                        <div
                            class="bg-gradient-to-br from-primary-100 to-primary-200 rounded-2xl h-96 flex items-center justify-center">
                            <div class="text-primary-600 text-6xl font-bold">AK</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </x-page-header>

    <div class="bg-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">{{ $skills['title'] }}</h2>
                <p class="text-xl text-gray-600">{{ $skills['content'] }}</p>
            </div>

            @if (isset($skills['meta']['categories']))
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    @foreach ($skills['meta']['categories'] as $category)
                        <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-100">
                            <h3 class="text-xl font-bold text-gray-900 mb-6">{{ $category['name'] }}</h3>

                            <div class="space-y-4">
                                @foreach ($category['skills'] as $skill)
                                    <div class="skill-item">
                                        <div class="flex items-center justify-between mb-2">
                                            <div class="flex items-center">
                                                <div
                                                    class="w-8 h-8 bg-primary-100 rounded-lg flex items-center justify-center mr-3">
                                                    <span class="text-primary-600 text-sm font-semibold">
                                                        {{ strtoupper(substr($skill['name'], 0, 2)) }}
                                                    </span>
                                                </div>
                                                <span class="font-medium text-gray-900">{{ $skill['name'] }}</span>
                                            </div>
                                            <span class="text-sm text-gray-500">{{ $skill['level'] }}%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-primary-600 h-2 rounded-full transition-all duration-300"
                                                style="width: {{ $skill['level'] }}%"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <div class="bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">{{ $experience['title'] }}</h2>
                <p class="text-xl text-gray-600">{{ $experience['content'] }}</p>
            </div>

            @if (isset($experience['meta']['timeline']))
                <div class="relative">
                    <div class="absolute left-4 md:left-1/2 transform md:-translate-x-1/2 w-0.5 h-full bg-primary-200">
                    </div>

                    <div class="space-y-12">
                        @foreach ($experience['meta']['timeline'] as $index => $item)
                            <div
                                class="relative flex flex-col md:flex-row items-start md:items-center {{ $index % 2 == 0 ? 'md:flex-row' : 'md:flex-row-reverse' }}">
                     
                                <div
                                    class="absolute left-4 md:left-1/2 transform md:-translate-x-1/2 w-4 h-4 bg-primary-600 rounded-full border-4 border-white shadow-lg z-10">
                                </div>

                                <div class="ml-12 md:ml-0 md:w-1/2 {{ $index % 2 == 0 ? 'md:pr-12' : 'md:pl-12' }}">
                                    <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-100">
                                        <div class="mb-4">
                                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $item['position'] }}</h3>
                                            <div class="text-primary-600 font-semibold mb-1">{{ $item['company'] }}</div>
                                            <div class="text-gray-500 text-sm mb-2">{{ $item['location'] }} •
                                                {{ $item['period'] }}</div>
                                        </div>

                                        <p class="text-gray-600 mb-4">{{ $item['description'] }}</p>

                                        @if (isset($item['achievements']))
                                            <div class="mb-4">
                                                <h4 class="font-semibold text-gray-900 mb-2">Key Achievements:</h4>
                                                <ul class="list-disc list-inside text-gray-600 space-y-1">
                                                    @foreach ($item['achievements'] as $achievement)
                                                        <li>{{ $achievement }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                        @if (isset($item['technologies']))
                                            <div class="flex flex-wrap gap-2">
                                                @foreach ($item['technologies'] as $tech)
                                                    <span
                                                        class="px-3 py-1 bg-primary-100 text-primary-700 rounded-full text-sm font-medium">
                                                        {{ $tech }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>


    <section class="section-padding">
        <div class="container-custom">
            <div class="bg-gradient-to-r from-primary-600 to-primary-700 rounded-2xl p-12 text-center text-white">
                @if (isset($cta['title']))
                    <h2 class="text-3xl font-bold mb-4">{{ $cta['title'] }}</h2>
                @else
                    <h2 class="text-3xl font-bold mb-4">Ready to Work Together?</h2>
                @endif

                @if (isset($cta['content']))
                    <p class="text-xl mb-8 opacity-90">{{ $cta['content'] }}</p>
                @else
                    <p class="text-xl mb-8 opacity-90">Let's discuss your next project and bring your ideas to life.</p>
                @endif

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('contact') }}" class="btn-white">
                        @if (isset($cta['meta']['primary_button_text']))
                            {{ $cta['meta']['primary_button_text'] }}
                        @else
                            Start a Project
                        @endif
                    </a>
                    <a href="{{ route('projects.index') }}" class="btn-outline-white">
                        @if (isset($cta['meta']['secondary_button_text']))
                            {{ $cta['meta']['secondary_button_text'] }}
                        @else
                            View My Work
                        @endif
                    </a>
                </div>
            </div>
        </div>
    </section>

  @if(isset($socialLinks['meta']['social_links']) && count($socialLinks['meta']['social_links']) > 0)
  <div class="bg-white py-12">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="text-center mb-12">
              <h2 class="text-3xl font-bold text-gray-900 mb-4">{{ $socialLinks['title'] ?? 'Connect With Me' }}</h2>
              <p class="text-xl text-gray-600">{{ $socialLinks['content'] ?? 'Follow me on social media for updates and insights' }}</p>
          </div>
          
          <div class="flex justify-center">
              <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6 max-w-4xl">
                  @foreach($socialLinks['meta']['social_links'] as $link)
                      @if(!empty($link['url']) && $link['url'] !== '#' && !empty($link['platform']))
                      <a href="{{ $link['url'] }}" 
                         target="_blank" 
                         rel="noopener noreferrer"
                         class="group bg-white rounded-lg shadow-md p-4 border border-gray-100 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 flex flex-col items-center">
                          <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center mb-3 group-hover:bg-primary-200 transition-colors duration-300">
                              @php
                                  $iconName = strtolower($link['icon'] ?? $link['platform']);
                              @endphp
                              
                              @if($iconName === 'linkedin')
                                  <svg class="w-6 h-6 text-primary-600" fill="currentColor" viewBox="0 0 24 24">
                                      <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                  </svg>
                              @elseif($iconName === 'github')
                                  <svg class="w-6 h-6 text-primary-600" fill="currentColor" viewBox="0 0 24 24">
                                      <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                                  </svg>
                              @elseif($iconName === 'twitter' || $iconName === 'x')
                                  <svg class="w-6 h-6 text-primary-600" fill="currentColor" viewBox="0 0 24 24">
                                      <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                  </svg>
                              @elseif($iconName === 'facebook')
                                  <svg class="w-6 h-6 text-primary-600" fill="currentColor" viewBox="0 0 24 24">
                                      <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                  </svg>
                              @elseif($iconName === 'instagram')
                                  <svg class="w-6 h-6 text-primary-600" fill="currentColor" viewBox="0 0 24 24">
                                      <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 6.62 5.367 11.987 11.988 11.987 6.62 0 11.987-5.367 11.987-11.987C24.014 5.367 18.637.001 12.017.001zM8.449 16.988c-1.297 0-2.448-.596-3.205-1.533l1.714-1.714c.39.586 1.07.977 1.85.977.827 0 1.524-.448 1.905-1.113l1.714 1.714c-.757.937-1.908 1.533-3.205 1.533zm7.119 0c-1.297 0-2.448-.596-3.205-1.533l1.714-1.714c.39.586 1.07.977 1.85.977.827 0 1.524-.448 1.905-1.113l1.714 1.714c-.757.937-1.908 1.533-3.205 1.533z"/>
                                  </svg>
                              @elseif($iconName === 'youtube')
                                  <svg class="w-6 h-6 text-primary-600" fill="currentColor" viewBox="0 0 24 24">
                                      <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                  </svg>
                              @elseif($iconName === 'artstation')
                                  <svg class="w-6 h-6 text-primary-600" fill="currentColor" viewBox="0 0 24 24">
                                      <path d="M0 17.723l2.027 3.505h.001a2.424 2.424 0 0 0 2.164 1.333h13.457l-2.792-4.838H0zm24 .025c0-.484-.143-.935-.388-1.314L15.728 2.728a2.424 2.424 0 0 0-2.142-1.289H9.419L21.598 22.54l1.92-3.325c.378-.378.482-.857.482-1.467zM2.419 6.578L10.261 20.6h11.457L13.876 6.578H2.419z"/>
                                  </svg>
                              @elseif($iconName === 'behance')
                                  <svg class="w-6 h-6 text-primary-600" fill="currentColor" viewBox="0 0 24 24">
                                      <path d="M6.938 4.503c.702 0 1.34.06 1.92.188.577.13 1.07.33 1.485.61.41.28.733.65.96 1.12.225.47.34 1.05.34 1.73 0 .74-.17 1.36-.507 1.86-.338.5-.837.9-1.502 1.22.906.26 1.576.72 2.022 1.37.448.66.665 1.45.665 2.36 0 .75-.13 1.39-.41 1.93-.28.55-.67 1-1.16 1.35-.48.348-1.05.6-1.67.76-.62.16-1.25.24-1.89.24H0V4.51h6.938v-.007zM16.94 16.665c.44.428 1.073.643 1.894.643.59 0 1.1-.148 1.53-.447.424-.29.68-.61.78-.94h2.588c-.403 1.28-1.048 2.2-1.9 2.75-.85.56-1.884.83-3.08.83-.837 0-1.584-.13-2.272-.4-.673-.27-1.24-.65-1.72-1.14-.464-.49-.823-1.08-1.077-1.77-.253-.69-.373-1.45-.373-2.27 0-.803.135-1.54.403-2.23.27-.7.644-1.28 1.12-1.79.495-.51 1.063-.9 1.736-1.194.672-.297 1.39-.447 2.17-.447.915 0 1.69.164 2.38.523.67.34 1.22.82 1.66 1.4.44.586.75 1.26.94 2.02.19.75.25 1.54.21 2.38h-7.69c0 .84.28 1.632.71 2.065l-.08.03zm-10.24.05c.317 0 .62-.03.906-.093.29-.06.548-.165.763-.3.21-.135.39-.328.52-.583.13-.24.19-.57.19-.96 0-.75-.22-1.29-.64-1.62-.43-.34-.99-.51-1.69-.51H3.24v4.05h3.47l-.01.02zm13.607-5.65c-.352-.385-.94-.592-1.657-.592-.468 0-.855.074-1.166.238-.302.15-.55.35-.74.59-.19.24-.317.49-.392.75-.075.26-.12.49-.135.71h4.762c-.07-.75-.32-1.39-.672-1.69v.01zM6.78 10.675c.594 0 1.097-.18 1.3-.48.2-.3.3-.67.3-1.05 0-.39-.1-.73-.3-1.05-.203-.32-.706-.48-1.3-.48H3.24v3.06h3.54z"/>
                                  </svg>
                              @elseif($iconName === 'dribbble')
                                  <svg class="w-6 h-6 text-primary-600" fill="currentColor" viewBox="0 0 24 24">
                                      <path d="M12 0C5.374 0 0 5.373 0 12s5.374 12 12 12 12-5.373 12-12S18.626 0 12 0zm9.568 5.302c.896 1.41 1.432 3.082 1.432 4.898 0 .142-.005.283-.014.424-.49-.092-5.38-.934-10.146-.934-.141 0-.283.003-.424.009-.051-.119-.104-.238-.158-.357-.134-.297-.277-.593-.428-.885 5.903-2.399 8.738-5.155 8.738-5.155zm-1.414-1.414s-2.835 2.756-8.738 5.155c-1.798-3.302-3.783-6.045-4.071-6.45C9.29.801 11.564.5 12 .5c2.034 0 3.923.674 5.154 1.388zM5.302 2.432c.288.405 2.273 3.148 4.071 6.45-5.126 1.364-9.633 1.35-10.146 1.35C-.227 7.218 2.033 4.353 5.302 2.432zM.5 12c0-.167.008-.333.022-.498.513.007 6.138.042 11.894-1.582.134.262.263.527.386.793.049.106.097.213.143.32-7.295 2.062-11.086 7.626-11.445 8.143C.84 17.747.5 14.966.5 12zm1.388 6.846c.359-.517 3.813-5.668 10.563-7.931 1.718 4.46 2.422 8.203 2.57 9.267C12.568 21.477 9.924 22.5 12 22.5c-2.188 0-4.18-.84-5.662-2.154zm8.154.654c-.148-1.064-.852-4.807-2.57-9.267 4.766.934 8.956 1.777 10.146 1.934-.896 3.957-3.747 7.317-7.576 7.333z"/>
                                  </svg>
                              @elseif($iconName === 'discord')
                                  <svg class="w-6 h-6 text-primary-600" fill="currentColor" viewBox="0 0 24 24">
                                      <path d="M20.317 4.3698a19.7913 19.7913 0 00-4.8851-1.5152.0741.0741 0 00-.0785.0371c-.211.3753-.4447.8648-.6083 1.2495-1.8447-.2762-3.68-.2762-5.4868 0-.1636-.3933-.4058-.8742-.6177-1.2495a.077.077 0 00-.0785-.037 19.7363 19.7363 0 00-4.8852 1.515.0699.0699 0 00-.0321.0277C.5334 9.0458-.319 13.5799.0992 18.0578a.0824.0824 0 00.0312.0561c2.0528 1.5076 4.0413 2.4228 5.9929 3.0294a.0777.0777 0 00.0842-.0276c.4616-.6304.8731-1.2952 1.226-1.9942a.076.076 0 00-.0416-.1057c-.6528-.2476-1.2743-.5495-1.8722-.8923a.077.077 0 01-.0076-.1277c.1258-.0943.2517-.1923.3718-.2914a.0743.0743 0 01.0776-.0105c3.9278 1.7933 8.18 1.7933 12.0614 0a.0739.0739 0 01.0785.0095c.1202.099.246.1981.3728.2924a.077.077 0 01-.0066.1276 12.2986 12.2986 0 01-1.873.8914.0766.0766 0 00-.0407.1067c.3604.698.7719 1.3628 1.225 1.9932a.076.076 0 00.0842.0286c1.961-.6067 3.9495-1.5219 6.0023-3.0294a.077.077 0 00.0313-.0552c.5004-5.177-.8382-9.6739-3.5485-13.6604a.061.061 0 00-.0312-.0286zM8.02 15.3312c-1.1825 0-2.1569-1.0857-2.1569-2.419 0-1.3332.9555-2.4189 2.157-2.4189 1.2108 0 2.1757 1.0952 2.1568 2.419-.0002 1.3332-.9555 2.4189-2.1569 2.4189zm7.9748 0c-1.1825 0-2.1569-1.0857-2.1569-2.419 0-1.3332.9554-2.4189 2.1569-2.4189 1.2108 0 2.1757 1.0952 2.1568 2.419 0 1.3332-.9555 2.4189-2.1568 2.4189Z"/>
                                  </svg>
                              @elseif($iconName === 'tiktok')
                                  <svg class="w-6 h-6 text-primary-600" fill="currentColor" viewBox="0 0 24 24">
                                      <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                                  </svg>
                              @elseif($iconName === 'whatsapp')
                                  <svg class="w-6 h-6 text-primary-600" fill="currentColor" viewBox="0 0 24 24">
                                      <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                                  </svg>
                              @elseif($iconName === 'telegram')
                                  <svg class="w-6 h-6 text-primary-600" fill="currentColor" viewBox="0 0 24 24">
                                      <path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
                                  </svg>
                              @else
                                  <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                  </svg>
                              @endif
                          </div>
                          <span class="text-sm font-medium text-gray-900 group-hover:text-primary-600 transition-colors duration-300 text-center">
                              {{ $link['platform'] }}
                          </span>
                      </a>
                      @endif
                  @endforeach
              </div>
          </div>
      </div>
  </div>
  @endif
 
    </div>
@endsection
