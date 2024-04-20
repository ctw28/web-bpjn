<!DOCTYPE html>
<html lang="en">
<head>
  @include('partials_head')
  @yield('head')
  <style>
    .main-content {
        padding-top: 15px; /* Sesuaikan nilai ini dengan tinggi navbar Anda */
    }    
  </style>  
  <script>
    var base_url="{{ url('/') }}";
  </script>
</head>
<body>
  <!-- Navbar -->
  @include('partials_navweb')

  <!-- Main content -->
  <div class="main-content mt-5">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-10 mx-auto"> <!-- Menggunakan mx-auto untuk membuat konten berada di tengah -->
            @yield('container')
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->

    <!-- Footer -->
  @include('partials_footer')
  <script src="{{ asset('js/myapp.js') }}"></script>
  <script>
    function getMenuWeb() {
        $.ajax({
            url: base_url+'/api/load-menu-tree',
            type: 'get',
            dataType: 'json',
            success: function(response) {
              buildMenu(response);
            },
            error: function(error) {
                console.error(error);
            }
        });
    }

    function buildMenu(menuData) {
      var dynamicMenu = $('#dynamicMenu');

      $.each(menuData, function(index, item) {
        if (item.url){
          var li = $('<li class="nav-item"></li>');
          var a = $('<a class="nav-link"></a>').text(item.text).attr('href', item.url);
          li.append(a);

          if (item.inc && item.inc.length > 0) {
              var subUl = $('<ul class="dropdown-menu"></ul>');
              $.each(item.inc, function(subIndex, subItem) {
                  var subLi = $('<li class="nav-item"></li>');
                  var subA = $('<a class="dropdown-item"></a>').text(subItem.text).attr('href', base_url+'/'+subItem.url);
                  subLi.append(subA);
                  subUl.append(subLi);
              });
              li.addClass('dropdown');
              a.addClass('dropdown-toggle').attr('data-bs-toggle', 'dropdown');
              li.append(subUl);
          }
          dynamicMenu.append(li);
        }
      });
    }
        
    $(document).ready(function() {
      getMenuWeb();
    });    
  </script>    
  @yield('script')
</body>
</html>
