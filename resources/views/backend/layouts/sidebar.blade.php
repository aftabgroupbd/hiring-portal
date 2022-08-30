<aside class="app-sidebar">
    <div class="app-sidebar__user">
      <img class="app-sidebar__user-avatar" width="50" src="{{asset('assets/backend/images/user.jpg')}}" alt="{{auth()->guard('admin')->user()->name}}">
      <div>
        <p class="app-sidebar__user-name">{{auth()->guard('admin')->user()->name}}</p>
      </div>
    </div>
    <ul class="app-menu">
      <li>
        <a class="app-menu__item active" href="{{route('admin.dashboard')}}">
          <i class="app-menu__icon fa fa-dashboard"></i>
          <span class="app-menu__label">Dashboard</span>
        </a>
      </li>
      <li class="treeview">
        <a class="app-menu__item" href="#" data-toggle="treeview">
          <i class="app-menu__icon fa fa-laptop"></i>
          <span class="app-menu__label">Users</span>
          <i class="treeview-indicator fa fa-angle-right"></i>
        </a>
        <ul class="treeview-menu">
          <li><a class="treeview-item" href="{{route('users.index')}}"><i class="icon fa fa-circle-o"></i>User List</a></li>
        </ul>
      </li>
      <li class="treeview">
        <a class="app-menu__item" href="#" data-toggle="treeview">
          <i class="app-menu__icon fa fa-laptop"></i>
          <span class="app-menu__label">Quizzes</span>
          <i class="treeview-indicator fa fa-angle-right"></i>
        </a>
        <ul class="treeview-menu">
          <li>
            <a class="treeview-item" href="{{route('admin.quizes.create')}}">
              <i class="icon fa fa-circle-o"></i>Create Quiz
            </a>
          </li>
          <li>
            <a class="treeview-item" href="{{route('admin.quizes.index')}}">
              <i class="icon fa fa-circle-o"></i>Quiz List
            </a>
          </li>
        </ul>
      </li>
      <li>
        <a class="app-menu__item" href="{{route('admin.submissions.index')}}">
          <i class="app-menu__icon fa fa-laptop"></i>
          <span class="app-menu__label">Submissions</span>
        </a>
      </li>
    </ul>
  </aside>