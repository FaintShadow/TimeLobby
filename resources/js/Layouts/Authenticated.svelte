<script>
    import ApplicationLogo from "@/Components/ApplicationLogo.svelte";
    import {inertia, page} from "@inertiajs/svelte";

    export let showNav = true;
    export let showProfile = true;

    $: succ = $page.props.success || null;
    $: user = $page.props.user;
</script>

<div class="min-h-dvh">
    <div class="navbar bg-base-100 z-40">
        <div class="navbar-start">
            {#if showNav}
                <div class="dropdown">
                    <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h8m-8 6h16"/>
                        </svg>
                    </div>
                    <ul class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow">
                        {#if user.role !== 'admin'}
                            <li>
                                <a>Academic</a>
                                <ul class="p-2">
                                    <li><a>Classes</a></li>
                                    <li><a>Students</a></li>
                                    <li><a>Subjects</a></li>
                                    <li><a>Teachers</a></li>
                                    <li><a>Years</a></li>
                                </ul>
                            </li>
                            <li><a href="">Institutes</a></li>
                            <li><a href="">Managers</a></li>
                            <li>
                                <a>Spaces</a>
                                <ul class="p-2">
                                    <li><a>Buildings</a></li>
                                    <li><a>Rooms</a></li>
                                </ul>
                            </li>
                            <li><a>Tags</a></li>
                            <li><a>Activities</a></li>
                        {:else if user.role === 'admin'}
                            <li><a href="/admin/academics" use:inertia>Academics</a></li>
                            <li><a href="/admin/institutes" use:inertia>Institutes</a></li>
                        {/if}
                    </ul>
                </div>
            {/if}
            <a class="btn btn-ghost text-xl" href="/" use:inertia>
                <ApplicationLogo class="h-8 w-8"></ApplicationLogo>
                <span>TimeLobby</span>
            </a>
        </div>
        {#if showNav}
            <div class="navbar-center hidden lg:flex">
                {#if user.role !== 'admin'}
                    <ul class="menu menu-horizontal px-1">
                        <li>
                            <details>
                                <summary>Academic</summary>
                                <ul class="p-2">
                                    <li><a>Classes</a></li>
                                    <li><a>Students</a></li>
                                    <li><a>Subjects</a></li>
                                    <li><a>Teachers</a></li>
                                    <li><a>Years</a></li>
                                </ul>
                            </details>
                        </li>
                        <li><a>Activities</a></li>
                        <li>
                            <details>
                                <summary>Space</summary>
                                <ul class="p-2">
                                    <li><a>Buildings</a></li>
                                    <li><a>Rooms</a></li>
                                </ul>
                            </details>
                        </li>
                        <li><a>Tags</a></li>
                    </ul>
                {:else if user.role === 'admin'}
                    <ul class="menu menu-horizontal px-1">
                        <li><a href="/admin/academics" use:inertia>Academics</a></li>
                        <li><a href="/admin/institutes" use:inertia>Institutes</a></li>
                    </ul>
                {/if}
            </div>
        {/if}
        <div class="navbar-end">
            {#if showProfile}
                <div class="dropdown dropdown-end">
                    <div tabindex="0" role="button" class="btn btn-ghost">
                        <span>{user.firstname[0].toUpperCase() + ". " + user.lastname.toUpperCase()}</span>
                    </div>
                    <ul class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow">
                        <li>
                            <a href="" class="justify-between">Profile</a>
                        </li>
                        <li><a>Settings</a></li>
                        <li><a href="{window.location.origin + '/logout'}">Logout</a></li>
                    </ul>
                </div>
            {/if}
        </div>
    </div>

    <!-- Notifications -->
    {#if $succ}
        <div class="toast toast-bottom toast-right">
            <div class="alert alert-info z-50">
                <span>{$succ}</span>
            </div>
        </div>
    {/if}


    <main {...$$restProps}>
        <slot/>
    </main>
</div>
