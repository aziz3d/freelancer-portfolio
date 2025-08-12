
<section class="py-12 sm:py-16 bg-white" aria-label="Professional statistics">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 sm:gap-8 text-center">
            <div class="p-4 sm:p-6 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                <div class="text-2xl sm:text-3xl font-bold text-primary-600 mb-2" aria-label="{{ $projectStats['total_projects'] }} plus projects completed">
                    {{ $projectStats['total_projects'] }}+
                </div>
                <div class="text-sm sm:text-base text-gray-600">Projects Completed</div>
            </div>
            <div class="p-4 sm:p-6 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                <div class="text-2xl sm:text-3xl font-bold text-primary-600 mb-2" aria-label="{{ $projectStats['years_experience'] }} plus years of experience">
                    {{ $projectStats['years_experience'] }}+
                </div>
                <div class="text-sm sm:text-base text-gray-600">Years Experience</div>
            </div>
            <div class="p-4 sm:p-6 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                <div class="text-2xl sm:text-3xl font-bold text-primary-600 mb-2" aria-label="{{ $projectStats['client_satisfaction'] }} percent client satisfaction">
                    {{ $projectStats['client_satisfaction'] }}%
                </div>
                <div class="text-sm sm:text-base text-gray-600">Client Satisfaction</div>
            </div>
        </div>
    </div>
</section>