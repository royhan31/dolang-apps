@extends('templates.default')

@section('content')
<div class="template-demo">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-custom">
      <li class="breadcrumb-item"><a href="{{route('tour')}}">Pariwisata</a></li>
      <li class="breadcrumb-item active" aria-current="page"><span>Tambah</span></li>
    </ol>
  </nav>
</div>
<div class="row">
  <div class="col-md-12 mt-4 d-flex align-items-stretch grid-margin">
    <div class="row flex-grow">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <form class="cmxform" id="create-tours" method="post" action="{{route('tour.store')}}" enctype="multipart/form-data">
              @csrf
              <fieldset>
              <div class="form-group">
                <label for="name">Nama</label>
                <input id="name" name="name" type="text" class="form-control" placeholder="Masukan Nama">
              </div>
              <div class="form-group">
                <label for="address">Alamat</label>
                <textarea id="address" name="address" class="form-control" rows="4" placeholder="Masukan Alamat"></textarea>
              </div>
              <div class="row">
                <div class="form-group col-4">
                  <label>Ketegori</label>
                  <select name="category" class="form-control">
                    <option>Bukit</option>
                    <option>Curug</option>
                    <option>Kolam Renang</option>
                    <option>Pantai</option>
                    <option>Taman</option>

                  </select>
                </div>
                <div class="form-group col-4">
                  <label for="region">Kecamatan</label>
                  <input id="region" type="text" name="region" value="{{old('region')}}" list="regions" class="form-control mt-1" placeholder="Masukan Kecamatan" />
                  <datalist id="regions">
                    <option value="Ampelgading">
                    <option value="Bantarbolang">
                    <option value="Belik">
                    <option value="Bodeh">
                    <option value="Comal">
                    <option value="Moga">
                    <option value="Pemalang">
                    <option value="Petarukan">
                    <option value="Pulosari">
                    <option value="Randudongkal">
                    <option value="Taman">
                    <option value="Ulujami">
                    <option value="Warungpring">
                    <option value="Watukumpul">
                  </datalist>
                </div>
                <div class="form-group row col-4">
                  <label for="price">HTM</label>
                    <input type="text" name="price" id="price" class="form-control" placeholder="Masukan HTM">
                </div>
              </div>
                <div class="form-group">
                  <label for="">Deskripsi</label>
                  <textarea name="description" class="form-control" id="description" rows="10" cols="20" required></textarea>
                </div>
                <div class="row mt-4">
                <div class="form-group col-6">
                   <label for="image">Foto</label>
                   <input type="file" name="image" id="image" class="file-upload-default" accept="image/*">
                   <div class="input-group col-xs-12">
                     <input type="text" class="form-control file-upload-info" disabled placeholder="Pilih Foto">
                     <span class="input-group-append">
                       <button class="file-upload-browse btn btn-info" type="button">Upload</button>
                     </span>
                   </div>
                 </div>
                 <div class="form-group col-6">
                    <label>Panorama</label>
                    <input type="file" name="panorama[]" id="panorama" class="file-upload-default" accept="image/*" multiple="multiple" required>
                    <div class="input-group col-xs-12">
                      <input type="text" class="form-control file-upload-info" disabled placeholder="Pilih Panorama">
                      <span class="input-group-append">
                        <button class="file-upload-browse btn btn-info" type="button">Upload</button>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="row mt-4">
                  <div class="form-group col-4">
                    <label for="name">Longitude</label>
                    <input type="text" id="long" name="long" class="form-control" value="{{ old('longitude') }}" placeholder="Longitude">
                  </div>
                  <div class="form-group col-4">
                    <label for="name">Latitude</label>
                    <input type="text" id="lat" name="lat" class="form-control" value="{{ old('latitude') }}" placeholder="Latitude">
                  </div>
                </div>
                <div class="mb-4">
                  <div id="map2" class="dashboard-map"></div>
                </div>
                <input class="btn btn-primary" type="submit" value="Submit">
              </fieldset>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
var tanpa_rupiah = document.getElementById('price');
tanpa_rupiah.addEventListener('keyup', function(e)
{
  // console.log(tanpa_rupiah.value.replace('.','').replace('.',''));
tanpa_rupiah.value = formatRupiah(this.value);
});


/* Fungsi */
function formatRupiah(angka, prefix)
{
var number_string = angka.replace(/[^,\d]/g, '').toString(),
split    = number_string.split(','),
sisa     = split[0].length % 3,
rupiah     = split[0].substr(0, sisa),
ribuan     = split[0].substr(sisa).match(/\d{3}/gi);

if (ribuan) {
separator = sisa ? '.' : '';
rupiah += separator + ribuan.join('.');
}

rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
}
</script>
<script type="text/javascript">

		var options = {
			center: [-6.894006,109.377652],
			zoom: 13
		}

		var map = L.map('map2', options);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  		maxZoom: 18,
  		id: 'mapbox.streets'
  	}).addTo(map);
		var myMarker = L.marker([-6.894006,109.377652], {draggable: true})
		.addTo(map)
    .on('dragend', function(e) {
      var coord = String(myMarker.getLatLng()).split(',');
      var lat = coord[0].split('(');
      var lng = coord[1].split(')');
      // myMarker.bindPopup("Moved to: " + lat[1] + ", " + lng[0] + ".");
      document.getElementById('lat').value = lat[1];
      document.getElementById('long').value = lng[0];
    });


	</script>
@endsection
