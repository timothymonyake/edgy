<!-- Modal Large -->
<div class="modal fade" tabindex="-1" id="{{$id}}">
    <div class="modal-dialog {{$size ?? ''}}" role="document">
        <div class="modal-content" style="background: white">
            <div class="modal-header" style="background: white;display:{{$display ?? 'block'}}">
                <h5 class="modal-title">{{$title}}</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            {{ $slot }}
        </div>
    </div>
</div>
