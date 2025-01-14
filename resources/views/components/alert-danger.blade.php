@props(['icon' => true, 'message' => null,'messages' => null,])

<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    @if(!empty($message))
        @if($icon)
            <i class="icon fas fa-ban"></i>
        @endif {{ $message }}
    @elseif(!empty($messages))
        @foreach($messages as $message)
            <div>
                @if($icon)
                    <i class="icon fas fa-ban"></i>
                @endif {{ $message }}
            </div>
        @endforeach
    @endif
</div>





