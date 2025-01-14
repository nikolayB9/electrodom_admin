@props(['icon' => true, 'message' => null,'messages' => null,])

<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    @if(!empty($message))
        @if($icon)
            <i class="icon fas fa-check"></i>
        @endif {{ $message }}
    @elseif(!empty($messages))
        @foreach($messages as $message)
            <div>
                @if($icon)
                    <i class="icon fas fa-check"></i>
                @endif {{ $message }}
            </div>
        @endforeach
    @endif
</div>





