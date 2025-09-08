<div class="flex gap-x-2 items-center">
    <img src="{{ $job->company->logo_path ?? '/storage/companies_logo/no-logo.png' }}" class="w-10 h-10 bg-red-50 rounded-full" alt="company logo image">
    <div class="flex flex-col">
        <a href="{{ route('company', ['id' => $job->company->id]) }}" class="hover:underline flex items-center gap-x-1">
            {{ $job->company->name }}
            @if ($job->company->verification()->exists() && $job->company->verification->status == "approved")
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M12 21a9 9 0 1 0 0-18a9 9 0 0 0 0 18m-.232-5.36l5-6l-1.536-1.28l-4.3 5.159l-2.225-2.226l-1.414 1.414l3 3l.774.774z" clip-rule="evenodd"/></svg>
            @endif
        </a>
        @if ($job->company->verification()->exists() && $job->company->verification->status == "approved")
            <span class="text-xs text-gray-500">verified</span>
        @else
            <span class="text-xs text-gray-500">not verified</span>
        @endif
    </div>
</div>