{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<x-backpack::menu-item title="{{ trans('admin.category') }}" icon="la la-question" :link="backpack_url('category')" />
<x-backpack::menu-item title="{{trans('admin.post')}}" icon="la la-question" :link="backpack_url('post')" />


<x-backpack::menu-item title="Contacts" icon="la la-question" :link="backpack_url('contact')" />

<x-backpack::menu-dropdown title="{{trans('admin.admin_manager')}}" icon="la la-puzzle-piece">
    <x-backpack::menu-dropdown-header title="Authentication" />
    <x-backpack::menu-dropdown-item title="Users" icon="la la-user" :link="backpack_url('user')" />
    <x-backpack::menu-dropdown-item title="Roles" icon="la la-group" :link="backpack_url('role')" />
    <x-backpack::menu-dropdown-item title="Permissions" icon="la la-key" :link="backpack_url('permission')" />
</x-backpack::menu-dropdown>


<x-backpack::menu-item title='Settings' icon='la la-cog' :link="backpack_url('setting')" />
<x-backpack::menu-item title="{{trans('admin.translation_manager')}}" icon="la la-stream" :link="backpack_url('translation-manager')" />


<x-backpack::menu-item title="Categories" icon="la la-question" :link="backpack_url('category')" />