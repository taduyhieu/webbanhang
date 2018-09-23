<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{!! gravatarUrl(Sentinel::getUser()->email) !!}" class="img-circle" alt="User Image" />

            </div>
            <div class="pull-left info">
                <p>{{ Sentinel::getUser()->full_name }}</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
                <span class="input-group-btn">
                    <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="{{ setActive('admin') }}"><a href="{{ url(getLang() . '/admin') }}"> <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a></li>
            @if(Sentinel::getRoles()[0]->name == 'SuperAdmin')
            <!--Menu-->
            <li class="{{ setActive('admin/menu*') }}"><a href="{{ url(getLang() . '/admin/menu') }}"> <i class="fa fa-bars"></i> <span>Menu</span> </a>
            </li>

            <!--News-->
            <!-- <li class="treeview {{ setActive('admin/news*') }}"><a href="#"> <i class="fa fa-newspaper-o"></i> <span>{{ trans('fully.menu_new') }}</span>
                    <i class="fa fa-angle-left pull-right"></i> </a>
                <ul class="treeview-menu">
                    <li><a href="{{ url(getLang() . '/admin/news') }}"><i class="fa fa-calendar"></i>{{ trans('fully.menu_new_list') }}</a>
                    </li>
                    <li><a href="{{ url(getLang() . '/admin/news-highlight') }}"><i class="glyphicon glyphicon-th-list"></i>Quản lý bài viết tiêu điểm</a>
                    </li>
                    <li><a href="{{ url(getLang() . '/admin/news-home') }}"><i class="glyphicon glyphicon-th-list"></i>Quản lý bài hiển thị trang chủ</a>
                    </li>
                    <li><a href="{{ url(getLang() . '/admin/news-cate') }}"><i class="glyphicon glyphicon-th-list"></i>Quản lý bài nổi bật chuyên mục</a>
                    </li>
                    <li><a href="{{ url(getLang() . '/admin/news-lens-re') }}"><i class="glyphicon glyphicon-th-list"></i>Quản lý bài ống kính BĐS</a>
                    </li>
                    <li><a href="{{ url(getLang() . '/admin/news-follow') }}"><i class="glyphicon glyphicon-th-list"></i>Quản lý bài theo dòng thời sự</a>
                    </li>
                    <li><a href="{{ url(getLang() . '/admin/news-comment') }}"><i class="glyphicon glyphicon-th-list"></i>Quản lý bình luận</a>
                    </li>
                    <li><a href="{{ url(getLang() . '/admin/news-tag') }}"><i class="glyphicon glyphicon-th-list"></i>{{ trans('fully.menu_tag_list') }}</a>
                    </li>
                </ul>
            </li> -->

            <!-- Category Realestale-->
            <!-- <li class="treeview {{ setActive('admin/realestale*') }}"><a href="#"> <i class="fa fa-newspaper-o"></i> <span>{{ trans('fully.menu_category_realestale') }}</span>
                    <i class="fa fa-angle-left pull-right"></i> </a>
                <ul class="treeview-menu">
                    <li><a href="{{ url(getLang() . '/admin/realestale-category') }}"><i class="fa fa-calendar"></i>{{ trans('fully.menu_category_realestale_list') }}</a>
                    </li>
                    <li><a href="{{ url(getLang() . '/admin/realestale-news') }}"><i class="fa fa-home"></i>Quản lý bài viết BĐS</a>
                    </li>
                    <li><a href="{{ url(getLang() . '/admin/realestale-tag') }}"><i class="glyphicon glyphicon-th-list"></i>Danh sách tag</a>
                    </li>
                </ul>
            </li> -->

            <!--Banner-->
<!--            <li class="treeview {{ setActive('admin/slider*') }}"><a href="#"> <i class="fa fa-image"></i> <span>{{ trans('fully.menu_banner') }}</span>
                    <i class="fa fa-angle-left pull-right"></i> </a>
                <ul class="treeview-menu">
                    <li><a href="{{ url(getLang() . '/admin/slider') }}"><i class="fa fa-toggle-up"></i> {{ trans('fully.menu_banner_slider') }}</a>
                    </li>
                </ul>
            </li>-->

            <!--Categories-->
            <li class="treeview {{ setActive('admin/categories*') }}"><a href="#"> <i class="fa fa-list-alt"></i> <span>{{ trans('fully.menu_cat') }}</span>
                    <i class="fa fa-angle-left pull-right"></i> </a>
                <ul class="treeview-menu">
                    <li><a href="{{ url(getLang() . '/admin/categories') }}"><i class="fa fa-list"></i> {{ trans('fully.menu_cat_list') }}</a>
                    </li>
                </ul>
            </li>

            <!--Videos-->
            <!-- <li class="treeview {{ setActive('admin/video*') }}"><a href="#"> <i class="glyphicon glyphicon-facetime-video"></i> <span>{{ trans('fully.menu_video') }}</span>
                    <i class="fa fa-angle-left pull-right"></i> </a>
                <ul class="treeview-menu">
                    <li><a href="{{ url(getLang() . '/admin/video') }}"><i class="fa fa-list"></i> {{ trans('fully.menu_video_list') }}</a>
                    </li>
                </ul>
            </li> -->

            <!--Slider-->
            <!-- <li class="treeview {{ setActive('admin/slider*') }}"><a href="#"> <i class="glyphicon glyphicon-picture"></i> <span>{{ trans('fully.menu_slider') }}</span>
                    <i class="fa fa-angle-left pull-right"></i> </a>
                <ul class="treeview-menu">
                    <li><a href="{{ url(getLang() . '/admin/slider') }}"><i class="fa fa-list"></i> {{ trans('fully.menu_slider_list') }}</a>
                    </li>
                </ul>
            </li> -->

            <!--Banner-->
            <li class="treeview {{ setActive('admin/banner*') }}"><a href="#"> <i class="glyphicon glyphicon-picture"></i> <span>{{ trans('fully.menu_banner') }}</span>
                    <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ url(getLang() . '/admin/banner') }}"><i class="fa fa-list"></i> {{ trans('fully.menu_banner_list') }}</a>
                    </li>
                </ul>
            </li>

            <!--Survey-->
            <!-- <li class="treeview {{ setActive('admin/survey*') }}"><a href="#"> <i class="fa fa-file"></i> <span>Quản lý khảo sát</span>
                    <i class="fa fa-angle-left pull-right"></i> </a>
                <ul class="treeview-menu">
                    <li><a href="{{ url(getLang() . '/admin/survey') }}"><i class="fa fa-list"></i> Danh sách khảo sát</a>
                    </li>
                </ul>
            </li> -->

            <!--User-->
            <!-- <li class="treeview {{ setActive(['admin/user*', 'admin/group*']) }}"><a href="#"> <i class="fa fa-user"></i> <span>{{ trans('fully.menu_user') }}</span>
                    <i class="fa fa-angle-left pull-right"></i> </a>
                <ul class="treeview-menu">
                    <li><a href="{{ url(getLang() . '/admin/user') }}"><i class="fa fa-user"></i> {{ trans('fully.menu_user_list') }}</a>
                    </li>
                    <li><a href="{{ url(getLang() . '/admin/user/wallet/'. Sentinel::getUser()->id) }}"><i class="fa fa-google-wallet"></i> Ví tiền</a>
                    </li>
                    <li><a href="{{ url(getLang() . '/admin/role') }}"><i class="fa fa-user"></i> {{ trans('fully.menu_role_add') }}</a>
                    </li>
                    <li><a href="{{ url(getLang() . '/admin/author') }}"><i class="fa fa-group"></i> Tạo tác giả</a>
                    </li>
                </ul>
            </li> -->
            @else
            <!-- Category Realestale-->
            <!-- <li class="treeview {{ setActive('admin/realestale*') }}"><a href="#"> <i class="fa fa-newspaper-o"></i> <span>{{ trans('fully.menu_category_realestale') }}</span>
                    <i class="fa fa-angle-left pull-right"></i> </a>
                <ul class="treeview-menu">
                    <li><a href="{{ url(getLang() . '/admin/realestale-news') }}"><i class="fa fa-home"></i>Quản lý bài viết BĐS</a>
                    </li>
                </ul>
            </li> -->
            @endif
            <!-- <li class="{{ setActive('admin/logout*') }}">
                <a href="{{ url('/admin/logout') }}"> <i class="fa fa-sign-out"></i> <span>{{ trans('fully.menu_logout') }}</span> </a>
            </li> -->
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>