@if (Auth::user())
    <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->

        <ul class="sidebar-menu">
            @php
                $user = Auth::user();
            @endphp


            <li class=""><a href="{{ url('/home') }}"><i class="fa fa-th-large" aria-hidden="true"></i> <span>Dashboard</span></a></li>
            @if( $user->role == 1 || $user->role == 2 )
            <!-- Optionally, you can add icons to the links -->
            <li class="treeview {{ (request()->is('home')) ? 'active' : '' }}"><a href="{{ url('/home') }}"><span>Home</span></a></li>

            
            <li class="treeview {{ (request()->is('hotels') || request()->is('outlets') || request()->is('manage/tables') || request()->is('assignratings') ) ? 'active' : '' }}"><a href="{{ url('/menuitems') }}">Restaurant Management</a>
                    <ul class="treeview-menu">
                        <li class="{{ (request()->is('hotels')) ? 'active' : '' }}">
                                <a href="{{ url('/hotels') }}"><i class="fa fa-file-o" aria-hidden="true"></i>Restaurants</a>
                        </li>
                        <li class="{{ (request()->is('outlets')) ? 'active' : '' }}">
                                <a href="{{ url('/outlets') }}"><i class="fa fa-file-o" aria-hidden="true"></i>Outlets</a>
                        </li>
                        <li class="{{ (request()->is('manage/tables')) ? 'active' : '' }}">
                                <a href="{{ url('/manage/tables') }}"><i class="fa fa-file-o" aria-hidden="true"></i>Tables</a>
                        </li>
                        <li class="{{ (request()->is('assignratings')) ? 'active' : '' }}">
                                <a href="{{ url('/assignratings') }}"><i class="fa fa-file-o" aria-hidden="true"></i>Assign Ratings</a>
                        </li>
                    </ul>
            </li>     
            <li class="treeview {{ (request()->is('menuitems') || request()->is('menugroups')) ? 'active' : '' }}"><a href="{{ url('/menuitems') }}">Menu Management</a>
                    <ul class="treeview-menu">
                        <li class="{{ (request()->is('menugroups')) ? 'active' : '' }}">
                                <a href="{{ url('/menugroups') }}"><i class="fa fa-file-o" aria-hidden="true"></i>Groups</a>
                        </li>
                        <li class="{{ (request()->is('menuitems')) ? 'active' : '' }}">
                                <a href="{{ url('/menuitems') }}"><i class="fa fa-file-o" aria-hidden="true"></i>Items</a>
                        </li>                    
                        <!-- <li class="{{ (request()->is('offers')) ? 'active' : '' }}">
                                <a href="{{ url('/offers') }}"><i class="fa fa-file-o" aria-hidden="true"></i>Offers</a>
                        </li> -->
                    </ul>
            </li> 
            
            <li class="treeview {{ (request()->is('users') || request()->is('roles')) ? 'active' : '' }}"><a href="{{ url('/menuitems') }}">User Management</a>
                    <ul class="treeview-menu">
                        <li class="{{ (request()->is('users')) ? 'active' : '' }}">
                                <a href="{{ url('/users') }}"><i class="fa fa-file-o" aria-hidden="true"></i>Users</a>
                        </li>
                        <li class="{{ (request()->is('roles')) ? 'active' : '' }}">
                            <a href="{{ url('/roles') }}"><i class="fa fa-file-o" aria-hidden="true"></i>Roles</a>
                        </li>
                    </ul>
            </li>

            <li class="treeview {{ (  request()->is('ratings')) ? 'active' : '' }}"><a href="{{ url('/menuitems') }}">Rating Management</a>
                    <ul class="treeview-menu">
                        <li class="{{ (request()->is('ratings')) ? 'active' : '' }}">
                                <a href="{{ url('/ratings') }}"><i class="fa fa-file-o" aria-hidden="true"></i>Rating Library</a>
                        </li>
                       
                        
                    </ul>
            </li>
            <li class="treeview {{ (request()->is('attributes') || request()->is('assignattributes')) ? 'active' : '' }}"><a href="{{ url('/attributes') }}">Attributes Management</a>
                    <ul class="treeview-menu">
                        <li class="{{ (request()->is('attributes')) ? 'active' : '' }}">
                                <a href="{{ url('/attributes') }}"><i class="fa fa-file-o" aria-hidden="true"></i>Attributes Library</a>
                        </li>
                        <li class="{{ (request()->is('assignattributes')) ? 'active' : '' }}">
                                <a href="{{ url('/assignattributes') }}"><i class="fa fa-file-o" aria-hidden="true"></i>Assign Attributes</a>
                        </li>                
                    </ul>
            </li>

            <!-- <li class="treeview {{ ( request()->is('pages') ) ? 'active' : '' }}"><a href="{{ url('/pages') }}">Pages</a></li>   -->
             
            


            @endif            
        </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
   @endif
