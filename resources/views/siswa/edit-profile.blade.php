@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-3">Edit Profil</h5>

                    <form id="editProfileForm" method="POST" action="{{ route('siswa.profile.update') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="nama" class="form-control" value="{{ old('nama', $siswa->nama) }}" required>
                        </div>

                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas" class="form-control" value="{{ old('kelas', $siswa->kelas) }}">
                        </div>

                        <div class="form-group">
                            <label>Jurusan</label>
                            <input type="text" name="jurusan" class="form-control" value="{{ old('jurusan', $siswa->jurusan) }}">
                        </div>

                        <div class="form-group">
                            <label>Foto Profil</label>
                            <div>
                                @if($siswa->avatar)
                                    <img id="currentAvatar" src="{{ asset($siswa->avatar) }}" alt="avatar" style="width:110px;height:110px;border-radius:50%;object-fit:cover;">
                                @else
                                    <div id="currentAvatar" style="width:110px;height:110px;border-radius:50%;background:#eee;display:inline-block;"></div>
                                @endif
                            </div>
                            <div class="mt-2">
                                <input id="avatarInput" type="file" accept="image/*" class="form-control-file">
                            </div>
                        </div>

                        <!-- Crop modal (opens automatically when a file is selected) -->
                        <div class="modal fade" id="cropModal" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Sesuaikan Foto Profil</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div style="max-height:60vh;overflow:auto;">
                                            <img id="cropImage" style="max-width:100%;display:block;margin:0 auto;"> 
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" id="cropBtn" class="btn btn-primary">Crop & Simpan</button>
                                        <button type="button" id="cancelCropBtn" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Hidden input to carry base64 cropped image --}}
                        <input type="hidden" name="cropped_avatar" id="cropped_avatar">

                        <div class="mt-4">
                            <button class="btn btn-success">Simpan Perubahan</button>
                            <a href="{{ route('siswa.profile') }}" class="btn btn-link">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<!-- Cropper.js via CDN -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function(){
    const avatarInput = document.getElementById('avatarInput');
    const cropImage = document.getElementById('cropImage');
    const croppedInput = document.getElementById('cropped_avatar');
    const currentAvatar = document.getElementById('currentAvatar');
    const $cropModal = $('#cropModal');
    let cropper = null;

    avatarInput.addEventListener('change', function(e){
        const file = e.target.files && e.target.files[0];
        if(!file) return;
        const url = URL.createObjectURL(file);
        cropImage.src = url;
        // open modal
        $cropModal.modal('show');
    });

    // handle modal hide: destroy cropper and reset input if cancelled
    $cropModal.on('hidden.bs.modal', function(){
        if(cropper) { cropper.destroy(); cropper = null; }
        avatarInput.value = '';
    });

    document.getElementById('cancelCropBtn').addEventListener('click', function(){
        $cropModal.modal('hide');
    });

    document.getElementById('cropBtn').addEventListener('click', function(){
        if(!cropper) return;
        const canvas = cropper.getCroppedCanvas({ width: 400, height: 400 });
        // create a circular masked canvas to export as PNG (preserve transparency)
        const sizeW = canvas.width;
        const sizeH = canvas.height;
        const circ = document.createElement('canvas');
        circ.width = sizeW;
        circ.height = sizeH;
        const ctx = circ.getContext('2d');
        // draw circle clip
        ctx.beginPath();
        ctx.arc(sizeW/2, sizeH/2, Math.min(sizeW, sizeH)/2, 0, Math.PI * 2, true);
        ctx.closePath();
        ctx.clip();
        // draw the cropped square canvas into the circular clipped area
        ctx.drawImage(canvas, 0, 0);
        // export as PNG to preserve transparency
        const dataUrl = circ.toDataURL('image/png');
        // show preview and make it circular
        currentAvatar.src = dataUrl;
        currentAvatar.style.borderRadius = '50%';
        currentAvatar.style.objectFit = 'cover';
        // set hidden input
        croppedInput.value = dataUrl;
        // cleanup and close modal
        $cropModal.modal('hide');
    });

    // initialize/destroy cropper when modal shown/hidden
    $cropModal.on('shown.bs.modal', function(){
        if(cropper) cropper.destroy();
        cropper = new Cropper(cropImage, { aspectRatio: 1, viewMode: 1, autoCropArea: 1 });
    });

    // On form submit, if cropped_avatar is set we keep it; else if a file was selected but not cropped, we let the file upload happen via normal multipart form
    document.getElementById('editProfileForm').addEventListener('submit', function(e){
        // nothing special needed; controller will accept cropped_avatar or file
    });
});
</script>

@endsection

