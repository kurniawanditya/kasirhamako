<div class="card">
        <div class="card-header"> 
          <h4> Select One Table</h4>
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered" id="table-artikel">
              <thead>
                <tr>
                  <th> No. </th>
                  <th> Judul Artikel</th>
                  <th> Kategori </th>
                  <th> Penulis </th>
                  <th> Tanggal Posting </th>
                  <th> Aksi </th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
            <br/>
        </div>
      </div>
    <!-- Optional JavaScript -->
    <script>
      var tabel = null;
      $(document).ready(function() {
          tabel = $('#table-artikel').DataTable({
              "processing": true,
              "serverSide": true,
              "ordering": true, // Set true agar bisa di sorting
              "order": [[ 0, 'asc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
              "ajax":
              {
                "url": "<?= base_url('Data/view_data');?>", // URL file untuk proses select datanya
                "type": "POST"
              },
              "deferRender": true,
              "aLengthMenu": [[5, 10, 50],[ 5, 10, 50]], // Combobox Limit
              "columns": [
                  {"data": 'id_item',"sortable": false, 
                    render: function (data, type, row, meta) {
                      return meta.row + meta.settings._iDisplayStart + 1;
                    }  
                  },
                  { "data": "barcode" }, // Tampilkan judul
                  { "data": "name" },  // Tampilkan kategori
                  { "data": "jenis" },  // Tampilkan penulis
                  { "data": "merk" },  // Tampilkan tgl posting
                  { "data": "id_item",
                    "render": 
                    function( data, type, row, meta ) {
                      return '<a href="show/'+data+'">Show</a>';
                    }
                  },
              ],
          });
      });
    </script>