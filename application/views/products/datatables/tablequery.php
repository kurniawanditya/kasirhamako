<div class="card">
        <div class="card-header">
          <h4> SQL Query With Join</h4>
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered" id="table-artikel-where">
              <thead>
                <tr>
                  <th> #. </th>
                  <th> Barcode</th>
                  <th> Name </th>
                  <th> Jenis </th>
                  <th> Merk </th>
                  <th> Aksi </th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
            <br/>
        </div>
      </div>
    </div>
    <!-- Optional JavaScript -->
     <!-- Optional JavaScript -->
     <script>
      var tabel = null;
      $(document).ready(function() {
          tabel = $('#table-artikel-where').DataTable({
              "processing": true,
              "serverSide": true,
              "ordering": true, // Set true agar bisa di sorting
              "order": [[ 0, 'asc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
              "ajax":
              {
                "url": "<?= base_url('data/view_data_query');?>", // URL file untuk proses select datanya
                "type": "POST"
              },
              "deferRender": true,
              "aLengthMenu": [[10, 50],[ 10, 50]], // Combobox Limit
              "columns": [
                  {"data": 'id_item',"sortable": false, 
                    render: function (data, type, row, meta) {
                      return meta.row + meta.settings._iDisplayStart + 1;
                    }  
                  },
                  { "data": "barcode" }, // Tampilkan judul
                  { "data": "name" },  // Tampilkan kategori
                  { "data": "hpp" },  // Tampilkan penulis
                  { "data": "fob" },  // Tampilkan tgl posting
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