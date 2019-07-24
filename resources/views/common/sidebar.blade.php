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
            <!-- Optionally, you can add icons to the links -->
            @if($user->role == 1)
                <li class="treeview {{ (request()->is('hotels')) ? 'active' : '' }}"><a href="{{ url('/hotels') }}"><span>Restaurants Management</span></a></li>  
                <li class="treeview {{ (request()->is('outlets')) ? 'active' : '' }}"><a href="{{ url('/outlets') }}"><span>Outlets Management</span></a></li>
            @endif    
            <li class="treeview {{ (request()->is('orders')) ? 'active' : '' }}"><a href="{{ url('orders') }}"><span>Orders Management</span></a></li>    
            <li class="treeview {{ (request()->is('users')) ? 'active' : '' }}"><a href="{{ url('/users') }}"><span>User Management</span></a></li>
            @if($user->role == 1)
                <li class="treeview {{ (request()->is('roles')) ? 'active' : '' }}"><a href="{{ url('/roles') }}"><span>Roles Management</span></a></li>
            @endif
            <li class="treeview {{ (request()->is('manage/tables')) ? 'active' : '' }}"><a href="{{ url('/manage/tables') }}"><span>Tables Management</span></a></li>
            <li class="treeview {{ (request()->is('menuitems') || request()->is('menugroups')) ? 'active' : '' }}"><a href="{{ url('/menuitems') }}">Menu Management</a>
                    <ul class="treeview-menu">
                        <li class="{{ (request()->is('menugroups')) ? 'active' : '' }}">
                                <a href="{{ url('/menugroups') }}"><i class="fa fa-file-o" aria-hidden="true"></i>Groups</a>
                        </li>
                        <li class="{{ (request()->is('menuitems')) ? 'active' : '' }}">
                                <a href="{{ url('/menuitems') }}"><i class="fa fa-file-o" aria-hidden="true"></i>Items</a>
                        </li>                    
                    </ul>
            </li>     
            <li class="treeview {{ (  request()->is('ratings')) ? 'active' : '' }}"><a href="#">Rating Management</a>
                    <ul class="treeview-menu">
                        @if($user->role == 1)
                                <li class="{{ (request()->is('ratings')) ? 'active' : '' }}">
                                        <a href="{{ url('/ratings') }}"><i class="fa fa-file-o" aria-hidden="true"></i>Rating Library</a>
                                </li>
                        @endif
                        <li class="{{ (request()->is('assignratings')) ? 'active' : '' }}">
                                <a href="{{ url('/assignratings') }}"><i class="fa fa-file-o" aria-hidden="true"></i>Assign Ratings</a>
                        </li>
                        
                    </ul>
            </li>
            
            <li class="treeview {{ (request()->is('attributes') || request()->is('assignattributes')) ? 'active' : '' }}"><a href="{{ url('/attributes') }}">Attributes Management</a>
                    <ul class="treeview-menu">
                        @if($user->role == 1)
                                <li class="{{ (request()->is('attributes')) ? 'active' : '' }}">
                                        <a href="{{ url('/attributes') }}"><i class="fa fa-file-o" aria-hidden="true"></i>Attributes Library</a>
                                </li>
                        @endif
                        <li class="{{ (request()->is('assignattributes')) ? 'active' : '' }}">
                                <a href="{{ url('/assignattributes') }}"><i class="fa fa-file-o" aria-hidden="true"></i>Assign Attributes</a>
                        </li>                
                    </ul>
            </li>
            <!--<li class="treeview {{ (request()->is('feedback')) ? 'active' : '' }}"><a href="{{ url('feedback') }}"><span>Feedback Management</span></a></li>-->

            <li class="treeview {{ (request()->is('customerfeedback') || request()->is('viewfeedback')) ? 'active' : '' }}"><a href="#">Feedback Management</a>
                    <ul class="treeview-menu">
                                <li class="{{ (request()->is('customerfeedback') || request()->is('viewfeedback')) ? 'active' : '' }}">
                                        <a href="{{ url('/customerfeedback') }}"><i class="fa fa-file-o" aria-hidden="true"></i>Customer's Feedbacks</a>
                                </li>
                                <!--<li class="{{ (request()->is('waiterfeedback')) ? 'active' : '' }}">
                                        <a href="{{ url('/waiterfeedback') }}"><i class="fa fa-file-o" aria-hidden="true"></i>Waiter's Feedbacks</a>
                                </li>-->                
                    </ul>
            </li>
            <!-- <li class="treeview {{ ( request()->is('pages') ) ? 'active' : '' }}"><a href="{{ url('/pages') }}">Pages</a></li>   -->     
        </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
   @endif
