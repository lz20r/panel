<script setup>
    import { ref, onMounted } from 'vue';
    import { Link, router, usePage, Head } from '@inertiajs/vue3';
    import ApplicationMark from '@/Components/ApplicationMark.vue';
    import Dropdown from '@/Components/Dropdown.vue';
    import DropdownLink from '@/Components/DropdownLink.vue';
    import '@fortawesome/fontawesome-free/css/all.min.css';
    import axios from 'axios';

    const currentTab = ref(route().current('dashboard') ? 'dashboard' : (route().current('settings') ? 'settings' : 'logs'));
    const logout = () => router.post(route('logout'));
    const showingNavigationDropdown = ref(false);
    const page = usePage();

    const switchToTeam = (team) => {
        router.put(route('current-team.update'), {
            team_id: team.id,
        }, {
            preserveState: false,
        });
    };

    const darkMode = ref(false);

    onMounted(() => {
        const saved = localStorage.getItem('darkMode');

        if (saved === null) {
            darkMode.value = $page.props.auth.user?.dark_mode ?? false;
        } else {
            darkMode.value = saved === 'true';
        }

        updateTheme();
    });
    function updateTheme() {
        document.documentElement.classList.toggle('dark', darkMode.value);
        localStorage.setItem('darkMode', darkMode.value);
        document.body.style.background = darkMode.value
            ? '#000000'
            : '#ffffff';
        document.body.style.color = darkMode.value ? '#fff' : '#000';
    }

    function toggleDarkMode() {
        darkMode.value = !darkMode.value;
        updateTheme();

        axios.post('/darkMode', {
            dark: darkMode.value
        })
            .then(() => {
                console.log('Dark mode guardado 🖤');
            })
            .catch((error) => {
                console.warn('Error al guardar el dark mode', error);
            });
    }
</script>

<template>
    <div>

        <Head title="Dashboard" />

        <div class="min-h-screen">
            <nav class="border-b border-zinc-290">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between text-sm">
                    <!-- Logo + Tabs -->
                    <div class="flex items-center gap-2">
                        <Link :href="route('dashboard')" class="flex items-center gap-2">
                        <ApplicationMark class="block h-8 w-auto" />
                        <span class="text-lg font-bold">Cinammon</span>
                        </Link>

                        <div class="hidden sm:flex items-center gap-2 text-sm font-medium text-gray-300">
                            <!-- Main Tabs -->

                            <Link :href="route('dashboard')" :class="{ 'bg-zinc-800': currentTab === 'dashboard' }"
                                class="flex gap-2 items-center px-3 py-2 rounded hover:bg-zinc-800"> <i
                                class="fa fa-home" aria-hidden="true"></i> Dashboard
                            </Link>
                            <Link :href="route('settings')" :class="{ 'bg-zinc-800': currentTab === 'settings' }"
                                class="flex gap-2 items-center px-3 py-2 rounded hover:bg-zinc-800"> <i
                                class="fa fa-cog" aria-hidden="true"></i> Settings
                            </Link>
                            <Link :href="route('logs')" :class="{ 'bg-zinc-800': currentTab === 'logs' }"
                                class="flex gap-2 items-center px-3 py-2 rounded hover:bg-zinc-800"> <i
                                class="fas fa-list-alt" aria-hidden="true"></i> Logs
                            </Link>

                            <!-- Dropdowns -->
                            <Dropdown align="left" width="48">
                                <template #trigger>
                                    <button
                                        class="flex items-center gap-2 px-3 py-2 rounded hover:bg-zinc-800 text-sm text-gray-400">
                                        Server <i class="fas fa-chevron-down text-xs"></i>
                                    </button>
                                </template>
                                <template #content>
                                    <DropdownLink :href="route('server.eggs')"><i class="fas fa-egg w-4"></i><span
                                            class="ml-2">Eggs</span></DropdownLink>
                                    <DropdownLink :href="route('server.nodes')"><i
                                            class="fas fa-network-wired w-4"></i><span class="ml-2">Nodes</span>
                                    </DropdownLink>
                                    <DropdownLink :href="route('server.servers')"><i class="fas fa-server w-4"></i><span
                                            class="ml-2">Servers</span></DropdownLink>
                                </template>
                            </Dropdown>

                            <Dropdown align="left" width="48">
                                <template #trigger>
                                    <button
                                        class="flex items-center gap-2 px-3 py-2 rounded hover:bg-zinc-800 text-sm text-gray-400">
                                        User <i class="fas fa-chevron-down text-xs"></i>
                                    </button>
                                </template>
                                <template #content>
                                    <DropdownLink :href="route('users.roles')"><i
                                            class="fas fa-user-shield w-4"></i><span class="ml-2">Roles</span>
                                    </DropdownLink>
                                    <DropdownLink :href="route('users')"><i class="fas fa-users w-4"></i><span
                                            class="ml-2">Users</span></DropdownLink>
                                </template>
                            </Dropdown>

                            <Dropdown align="left" width="48">
                                <template #trigger>
                                    <button
                                        class="flex items-center gap-2 px-3 py-2 rounded hover:bg-zinc-800 text-sm text-gray-400">
                                        Advanced <i class="fas fa-chevron-down text-xs"></i>
                                    </button>
                                </template>
                                <template #content>
                                    <DropdownLink :href="route('advanced.health')"><i
                                            class="fas fa-heartbeat w-4"></i><span class="ml-2">Health</span>
                                    </DropdownLink>
                                    <DropdownLink :href="route('advanced.api')"><i class="fas fa-key w-4"></i><span
                                            class="ml-2">API Keys</span></DropdownLink>
                                    <DropdownLink :href="route('advanced.db')"><i class="fas fa-database w-4"></i><span
                                            class="ml-2">Database Hosts</span></DropdownLink>
                                    <DropdownLink :href="route('advanced.mounts')"><i class="fas fa-hdd w-4"></i><span
                                            class="ml-2">Mounts</span></DropdownLink>
                                    <DropdownLink :href="route('advanced.webhooks')"><i
                                            class="fas fa-plug w-4"></i><span class="ml-2">Webhooks</span>
                                    </DropdownLink>
                                </template>
                            </Dropdown>
                        </div>
                    </div>
                    <div class="flex items-center gap-5">
                        <div class="flex items-center gap-2">
                            <div
                                class="block flex items-center rounded-lg shadow-sm ring-1 ring-gray-200 dark:ring-black/20 focus-within:ring-2 focus-within:ring-primary-600 bg-black dark:bg-black/5">
                                <div class="px-3 text-gray-400">
                                    <i class="fas fa-search"></i>
                                </div>
                                <input type="search" placeholder="Search..." name="search"
                                    class="bg-transparent border-none text-sm text-gray-900 dark:text-black placeholder-gray-400 dark:placeholder-gray-500 focus:ring-0 py-1.5 px-2" />
                            </div>
                            <!-- Notifications Dropdown -->
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <button class="flex text-sm focus:outline-none focus:border-zinc-600">
                                        <i class="fas fa-bell"></i>
                                    </button>
                                </template>
                                <template #content>
                                    <div class="px-4 py-2 text-xs text-gray-400">Notifications</div>
                                    <div class="px-4 py-2 text-xs text-gray-400">No new notifications</div>
                                </template>
                            </Dropdown>
                            <!-- Messages Dropdown -->
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <button class="flex text-sm focus:outline-none focus:border-zinc-600">
                                        <i class="fas fa-envelope"></i>
                                    </button>
                                </template>
                                <template #content>
                                    <div class="px-4 py-2 text-xs text-gray-400">Messages</div>
                                    <div class="px-4 py-2 text-xs text-gray-400">No new messages</div>
                                </template>
                            </Dropdown>
                            <!-- Dark Mode Toggle -->
                            <button @click="toggleDarkMode"
                                class="flex text-sm focus:outline-none focus:border-zinc-600">
                                <i class="fas" :class="darkMode ? 'fa-moon' : 'fa-sun'"></i>
                            </button>
                        </div>

                        <!-- Avatar Dropdown -->
                        <Dropdown align="right" width="48">
                            <template #trigger>
                                <button
                                    class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-zinc-600">
                                    <img class="h-8 w-8 rounded-full object-cover"
                                        :src="page.props.auth.user.profile_photo_url"
                                        :alt="page.props.auth.user.name" />
                                </button>
                            </template>
                            <template #content>
                                <div class="px-4 py-2 text-xs text-gray-400">Manage Account</div>
                                <DropdownLink :href="route('profile.show')">Profile</DropdownLink>
                                <DropdownLink v-if="page.props.jetstream.hasApiFeatures"
                                    :href="route('api-tokens.index')">
                                    API Tokens</DropdownLink>
                                <div class="border-t border-zinc-700 my-1" />
                                <form @submit.prevent="logout">
                                    <DropdownLink as="button">Log Out</DropdownLink>
                                </form>
                            </template>
                        </Dropdown>


                        <!-- Hamburger -->
                        <button @click="showingNavigationDropdown = !showingNavigationDropdown"
                            class="sm:hidden text-gray-400 focus:outline-none focus:text-black">
                            <i class="fas" :class="showingNavigationDropdown ? 'fa-times' : 'fa-bars'"></i>
                        </button>
                    </div>
                </div>
            </nav>

            <!-- Responsive Navigation Dropdown -->
            <div :class="{ 'block': showingNavigationDropdown, 'hidden': !showingNavigationDropdown }">
                <div class="px-4 py-2 text-xs text-gray-400">Menu</div>
                <DropdownLink :href="route('dashboard')" class="py-2 px-4">Dashboard</DropdownLink>
                <DropdownLink :href="route('settings')" class="py-2 px-4">Settings</DropdownLink>
                <DropdownLink :href="route('logs')" class="py-2 px-4">Logs</DropdownLink>
                <div class="border-t border-zinc-700 my-1" />
                <div class="py-2 px-4 text-xs text-gray-400">Server</div>
                <DropdownLink :href="route('server.eggs')" class="py-2 px-4">Eggs</DropdownLink>
                <DropdownLink :href="route('server.nodes')" class="py-2 px-4">Nodes</DropdownLink>
                <DropdownLink :href="route('server.servers')" class="py-2 px-4">Servers</DropdownLink>
                <div class="border-t border-zinc-700 my-1" />
                <div class="py-2 px-4 text-xs text-gray-400">User</div>
                <DropdownLink :href="route('users.roles')" class="py-2 px-4">Roles</DropdownLink>
                <DropdownLink :href="route('users')" class="py-2 px-4">Users</DropdownLink>
                <div class="border-t border-zinc-700 my-1" />
                <div class="py-2 px-4 text-xs text-gray-400">Advanced</div>
                <DropdownLink :href="route('advanced.health')" class="py-2 px-4">Health</DropdownLink>
                <DropdownLink :href="route('advanced.api')" class="py-2 px-4">API Keys</DropdownLink>
                <DropdownLink :href="route('advanced.db')" class="py-2 px-4">Database Hosts</DropdownLink>
                <DropdownLink :href="route('advanced.mounts')" class="py-2 px-4">Mounts</DropdownLink>
                <DropdownLink :href="route('advanced.webhooks')" class="py-2 px-4">Webhooks</DropdownLink>
                <div class="border-t border-zinc-700 my-1" />
                <div class="py-2 px-4 text-xs text-gray-400">Account</div>
                <DropdownLink :href="route('profile.show')" class="py-2 px-4">Profile</DropdownLink>
                <DropdownLink v-if="page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')"
                    class="py-2 px-4">
                    API Tokens</DropdownLink>
                <form @submit.prevent="logout">
                    <DropdownLink as="button" class="py-2 px-4">Log Out</DropdownLink>
                </form>
            </div>


            <!-- Page Content -->
            <main class="max-w-7xl mx-auto px-4 py-6">
                <slot name="header"></slot>
                <slot></slot>
            </main>
        </div>
    </div>
</template>
