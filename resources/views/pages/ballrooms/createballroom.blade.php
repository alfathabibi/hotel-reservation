@extends('main')

@section('content')
@if (session()->has('success'))
    <script>
        $(document).ready(function(){
            $("#modalSuccess").modal('show');
        });
    </script>
  @endif
<div class="row justify-content-md-center">
    <div class="col-12">
        <div class="card mb-4">
          <div class="card-header pb-0 p-3">
            <div class="row">
              <div class="col-6 d-flex align-items-center">
                <h4 class="mb-0">Add Ballrooms</h6>
              </div>
            </div>
          </div>
          <div class="card-body p-3">
            <div class="row">
              <div class="col-6">
                <form role="form" action="create" method="post" enctype="multipart/form-data">
                  @csrf
                  <label>Ballroom Name</label>
                  <div class="mb-3">
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}" placeholder="Ballroom Alpha" aria-label="name" aria-describedby="email-addon" required>   
                    @error('name')
                    <div class="invalid-feedback">
                      {{$message}}
                    </div>
                    @enderror
                  </div>
                  <label>Price</label>
                  <div class="mb-3">
                    <input type="text" name="price" class="form-control @error('price') is-invalid @enderror" value="{{old('price')}}" placeholder="250000" aria-label="price" aria-describedby="email-addon" required>   
                    @error('price')
                    <div class="invalid-feedback">
                      {{$message}}
                    </div>
                    @enderror
                  </div>
                  <label>Capacity</label>
                  <div class="mb-3">
                    <select class="form-select" name="capacity">
                      <option value="500">500 guests</option>
                      <option value="1000">1000 guest</option>
                    </select>
                    @error('capacity')
                    <div class="invalid-feedback">
                      {{$message}}
                    </div>
                    @enderror
                  </div>
                  <label>Ballroom Area</label>
                  <div class="mb-3">
                    <input type="text" name="area" class="form-control @error('area') is-invalid @enderror" value="{{old('area')}}" placeholder="15" aria-label="area" aria-describedby="email-addon" required>   
                    @error('area')
                    <div class="invalid-feedback">
                      {{$message}}
                    </div>
                    @enderror
                  </div>
                  <label>Floor</label>
                  <div class="mb-3">
                    <input type="text" name="floor" class="form-control @error('floor') is-invalid @enderror" value="{{old('floor')}}" placeholder="1" aria-label="floor" aria-describedby="email-addon" required>   
                    @error('floor')
                    <div class="invalid-feedback">
                      {{$message}}
                    </div>
                    @enderror
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn bg-gradient-primary w-100 mt-4 mb-0">Add</button>
                  </div>
              </div>
              <div class="col-6">
                <label>Facility</label>
                    <div class="mb-3">
                        <select class="form-select" name="facility">
                        <option value="yes">With Equipment</option>
                        <option value="no">Without Equipment</option>
                        </select>
                        @error('facility')
                        <div class="invalid-feedback">
                        {{$message}}
                        </div>
                        @enderror
                    </div>  
                  <div class="mb-3">
                    <label for="formFile" class="form-label">Upload Photo 1</label>
                    <input class="form-control" type="file" name="photo1" id="formFile" accept="image/png, image/jpg, image/jpeg" required>
                  </div>
                  <div class="mb-3">
                    <label for="formFile" class="form-label">Upload Photo 2</label>
                    <input class="form-control" type="file" name="photo2" id="formFile" accept="image/png, image/jpg, image/jpeg" required>
                  </div>
                  <div class="mb-3">
                    <label for="formFile" class="form-label">Upload Photo 3</label>
                    <input class="form-control" type="file" name="photo3" id="formFile" accept="image/png, image/jpg, image/jpeg" required>
                  </div>
              </div>
              </form>
            </div>
          </div>
        </div>
    </div>
</div>

{{-- Modal --}}
<div class="modal fade" id="modalSuccess" aria-hidden="true" aria-labelledby="modalSuccess" tabindex="-1">
  <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <div class="container">
            <div class="row justify-content-center">
              <div class="col text-center">
                <i class="fas fa-check-circle text-success fs-1"></i>
                <h4>Success</h4>
              </div>
            </div>
            <div class="row justify-content-center">
              <div class="col text-center">
                <p>Add Ballroom Successfully</p>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection