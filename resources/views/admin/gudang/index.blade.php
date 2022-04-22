<x-app-layout>
	<x-slot name="title">Daftar Gudang</x-slot>

	<x-alert-error></x-alert-error>

	@if(session()->has('success'))
	<x-alert type="success" message="{{ session()->get('success') }}" />
	@endif

	<x-card>
		<x-slot name="title">Semua Gudang</x-slot>
		<x-slot name="option">
			<button class="btn btn-primary add"><i class="fas fa-plus"></i> Tambah Gudang</button>
		</x-slot>

		<table class="table table-hover mb-3">
			<thead>
				<th>Kode Gudang</th>
				<th>Nama Gudang</th>
				<th>Jumlah Barang</th>
				<th></th>
			</thead>
			<tbody>
				@foreach ($data as $row)
					<tr>
						<td>{{ $row->kode }}</td>
						<td>{{ $row->nama }}</td>
						<td>{{ $row->barangs()->sum('jumlah') }}</td>
						<td class="text-center">
							<button class="btn btn-sm btn-info info" data-id="{{ $row->id }}"><i class="fas fa-info-circle"></i></button>
							<button class="btn btn-sm btn-primary edit" data-id="{{ $row->id }}"><i class="fas fa-edit"></i></button>
							<form action="{{ route('admin.gudang.destroy', $row->id) }}" style="display: inline-block;" method="POST">
							@csrf
							<button type="button" class="btn btn-sm btn-danger delete"><i class="fas fa-trash"></i></button>
						</form>
						</td>
					</tr>
				@endforeach
				
			</tbody>
		</table>
	</x-card>

	{{-- add model --}}
	<x-modal>
		<x-slot name="title">
			<h6 class="m-0 font-weight-bold text-primary">Tambahkan Gudang</h6>
		</x-slot>
		<x-slot name="id">add</x-slot>


		<form action="{{ route('admin.gudang.store') }}" method="post" class="form-group">
			@csrf
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="">Kode Gudang</label>
						<input type="text" class="form-control" name="kode" required="">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="">Nama Gudang</label>
						<input type="text" class="form-control" name="nama" required="">
					</div>
				</div>
			</div>
			<div class="form-group">
				<textarea name="catatan" id="" cols="30" rows="10" class="form-control" placeholder="Catatan"></textarea>
			</div>
			<button type="submit" class="btn btn-primary">Simpan</button>
		</form>
	</x-modal>

	{{-- edit model --}}
	<x-modal>
		<x-slot name="title">
			<h6 class="m-0 font-weight-bold text-primary">Edit Gudang</h6>
		</x-slot>
		<x-slot name="id">edit</x-slot>


		<form action="{{ route('admin.gudang.update') }}" method="post" id="edit" class="form-group">
			@csrf
			<input type="hidden" name="id" value="">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="">Kode Gudang</label>
						<input type="text" class="form-control" name="kode" required="">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="">Nama Gudang</label>
						<input type="text" class="form-control" name="nama" required="">
					</div>
				</div>
			</div>
			<div class="form-group">
				<textarea name="catatan" id="" cols="30" rows="10" class="form-control" placeholder="Catatan"></textarea>
			</div>
			<button type="submit" class="btn btn-primary">Simpan</button>
		</form>
	</x-modal>

	{{-- info modal --}}
	<x-modal>
		<x-slot name="title">
			<h6 class="m-0 font-weight-bold text-primary">Informasi Gudang</h6>
		</x-slot>
		<x-slot name="id">info</x-slot>

		<div class="row">
			<div class="col-md-6">
				<span>Kode Gudang</span>
			</div>
			<div class="col-md-6">
				: <span id="kode"></span>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<span>Nama Gudang</span>
			</div>
			<div class="col-md-6">
				: <span id="nama"></span>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<span>Catatan</span>
			</div>
			<div class="col-md-6">
				: <span id="catatan"></span>
			</div>
		</div>
	</x-modal>

	<x-slot name="script">
		<script src="{{ asset('dist/vendor/datatables/jquery.dataTables.min.js') }}"></script>
		<script src="{{ asset('dist/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
		<script>
			$('.add').click(function() {
				$('#add').modal('show')
			})

			$('.info').click(function() {
				const id = $(this).data('id')

				$.get(`{{ route('admin.gudang.info') }}?id=${id}`, function(data) {
					$('#nama').text(data.nama)
					$('#kode').text(data.kode)
					$('#catatan').text(data.catatan)
				})

				$('#info').modal('show')
			})

			$('.edit').click(function() {
				const id = $(this).data('id')

				$.get(`{{ route('admin.gudang.info') }}?id=${id}`, function(data) {
					$('#edit input[name="id"]').val(id)

					$('#edit input[name="nama"]').val(data.nama)
					$('#edit input[name="kode"]').val(data.kode)
					$('#edit textarea[name="catatan"]').val(data.catatan)
				})

				$('#edit').modal('show')
			})

			$('.delete').click(function(e){
				e.preventDefault()
				Swal.fire({
				  title: 'Ingin menghapus?',
				  text: 'Data akan dihapus permanen',
				  icon: 'warning',
				  showCancelButton: true,
				  confirmButtonText: 'Hapus',
				  cancelButtonText: 'Batal'
				}).then((result) => {
					if (result.isConfirmed) {
				  		$(this).parent().submit()
					} 
				})

			})

			$(document).ready(function () {
		      $('table').DataTable();
		    });
		</script>
	</x-slot>
</x-app-layout>