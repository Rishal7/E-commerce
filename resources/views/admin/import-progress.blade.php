@if (!is_null($batch) && $batch->progress() < 100)

<div class="mt-4 mb-1 flex justify-between">
    <span class="text-xs font-medium text-blue-700 dark:text-white">{{ $batch->progress() }}%</span>
  </div>
  <div class="w-full bg-gray-200 rounded-full h-2 dark:bg-gray-700">
    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $batch->progress() }}%"></div>
  </div>
  
@endif

@if ($down && $batch->progress() == 100)
    <p class="mt-4 text-sm">Completed</p>
@endif

