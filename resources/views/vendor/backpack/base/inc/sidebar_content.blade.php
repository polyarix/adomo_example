<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li><a href="{{ backpack_url('dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('admin.statistic') }}</span></a></li>

@can('administrate')
    <li class="treeview">
        <a href="#"><i class="fa fa-group"></i> <span>{{ trans('admin.categories') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li><a href='{{ backpack_url('categories') }}'><i class='fa fa-folder'></i> <span>{{ trans('admin.categories') }}</span></a></li>
            <li><a href='{{ backpack_url('category/tags') }}'><i class='fa fa-tag'></i> <span>{{ trans('admin.tags') }}</span></a></li>
        </ul>
    </li>
@endcan

@can('moderate')
    <li class="treeview">
        <a href="#"><i class="fa fa-group"></i> <span>{{ trans('admin.adverts') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li><a href='{{ backpack_url('advert/orders') }}'><i class='fa fa-clone'></i> <span>{{ trans('admin.orders') }}</span></a></li>
            <li><a href='{{ backpack_url('advert/services') }}'><i class='fa fa-sticky-note-o'></i> <span>{{ trans('admin.services') }}</span></a></li>
        </ul>
    </li>
@endcan

@can('moderate')
    <li class="treeview">
        <a href="#"><i class="fa fa-group"></i> <span>{{ trans('admin.users') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li><a href='{{ backpack_url('users') }}'><i class='fa fa-clone'></i> <span>{{ trans('admin.users') }}</span></a></li>
        </ul>
    </li>
@endcan

@can('administrate')
    <li class="treeview">
        <a href="#"><i class="fa fa-group"></i> <span>{{ trans('admin.companies') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li><a href='{{ backpack_url('companies') }}'><i class='fa fa-clone'></i> <span>{{ trans('admin.companies') }}</span></a></li>
            <li><a href='{{ backpack_url('company/articles') }}'><i class='fa fa-file-word-o'></i> <span>{{ trans('admin.articles') }}</span></a></li>
            <li><a href='{{ backpack_url('company/works') }}'><i class='fa fa-briefcase'></i> <span>{{ trans('admin.works') }}</span></a></li>
        </ul>
    </li>
@endcan

@can('administrate')
    <li><a href='{{ backpack_url('cities') }}'><i class='fa fa-tag'></i> <span>{{ trans('admin.cities') }}</span></a></li>
@endcan

@can('moderate')
    <li>
        <a href='{{ backpack_url('contact_requests') }}'>
            <i class='fa fa-book'></i> <span>{{ trans('admin.contact_requests') }}</span>
            @if($new_contact_requests > 0)
                <span class="label pull-right label-primary">+{{ $new_contact_requests }}</span>
            @endif
        </a>
    </li>
@endcan

@can('administrate')
    <li class="treeview">
        <a href="#"><i class="fa fa-group"></i> <span>{{ trans('admin.main') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li><a href='{{ backpack_url('variables') }}'><i class='fa fa-clone'></i> <span>{{ trans('admin.common_params') }}</span></a></li>
            <li><a href='{{ backpack_url('banners') }}'><i class='fa fa-clone'></i> <span>{{ trans('admin.banners') }}</span></a></li>
            <li><a href='{{ backpack_url('faq') }}'><i class='fa fa-question-circle'></i> <span>{{ trans('admin.faq') }}</span></a></li>
        </ul>
    </li>
@endcan

@can('administrate')
    <li class="treeview">
        <a href="#"><i class="fa fa-group"></i> <span>{{ trans('admin.main_page') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li><a href='{{ backpack_url('sliders') }}'><i class='fa fa-clone'></i> <span>{{ trans('admin.sliders') }}</span></a></li>
        </ul>
    </li>
@endcan

@can('administrate')
    <li class="treeview">
        <a href="#"><i class="fa fa-group"></i> <span>{{ trans('admin.pages_management') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li><a href='{{ backpack_url('main_page') }}'><i class='fa fa-inbox'></i> <span>{{ trans('admin.main_page_management') }}</span></a></li>
            <li><a href='{{ backpack_url('about_page') }}'><i class='fa fa-inbox'></i> <span>{{ trans('admin.about_page_management') }}</span></a></li>
            <li><a href='{{ backpack_url('contacts_page') }}'><i class='fa fa-inbox'></i> <span>{{ trans('admin.contacts_page_management') }}</span></a></li>
            <li><a href='{{ backpack_url('faq_page') }}'><i class='fa fa-inbox'></i> <span>{{ trans('admin.faq_page_management') }}</span></a></li>
        </ul>
    </li>
@endcan

@can('administrate')
    <li class="treeview">
        <a href="#"><i class="fa fa-archive"></i> <span>{{ trans('admin.blog') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li><a href='{{ backpack_url('blog/categories') }}'><i class='fa fa-folder'></i> <span>{{ trans('admin.categories') }}</span></a></li>
            <li><a href='{{ backpack_url('blog/articles') }}'><i class='fa fa-clone'></i> <span>{{ trans('admin.articles') }}</span></a></li>

            <li>
                <a href='{{ backpack_url('blog/comments') }}'>
                    <i class='fa fa-comment'></i> <span>{{ trans('admin.comments') }}</span>

                    @if($comments_on_moderation > 0)
                        <span class="label pull-right label-warning">+{{ $comments_on_moderation }}</span>
                    @endif
                </a>
            </li>
        </ul>
    </li>
@endcan
