@extends('template')

@section('head')
    <title>Jenis Konten</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />
@endsection

@section('container')

    <h1>Menu Web</h1>
    <p>digunakan untuk mengatur menu pada tampilan utama website ini </p>

    <div class="row">
        <div class="col-sm-12">
            <div class="input-group justify-content-end">
                <button type="button" class="btn btn-sm btn-outline-secondary" id="tambah" onclick="tambah()">Tambah</button>
                <button type="button" class="btn btn-sm btn-outline-secondary" id="refresh">Refresh</button>
            </div>
        </div>
    </div>

    <div id="jstree">
        <!-- in this example the tree is populated from inline HTML -->
        <ul>
          <li>Root node 1
            <ul>
              <li>Child node 1</li>
                <ul>
                    <li>Child node 1.1</li>
                    <li>Child node 1.2</li>
                </ul>  
              <li>Child node 2</li>
            </ul>
          </li>
          <li>Root node 2</li>
        </ul>
      </div>
      <button>demo button</button>

@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>
<script src="{{ asset('js/pagination.js') }}"></script>
<script src="{{ asset('js/token.js') }}"></script>

<script>
    var vApiUrl='api/jenis-konten';

    $(function () {
        // 6 create an instance when the DOM is ready
        $('#jstree').jstree();
        
        // 7 bind to events triggered on the tree
        $('#jstree').on("changed.jstree", function (e, data) {
            console.log(data.selected);
        });
        
        // 8 interact with the tree - either way is OK
        $('button').on('click', function () {
            $('#jstree').jstree(true).select_node('child_node_1');
            $('#jstree').jstree('select_node', 'child_node_1');
            $.jstree.reference('#jstree').select_node('child_node_1');
        });
    });


</script>
@endsection
