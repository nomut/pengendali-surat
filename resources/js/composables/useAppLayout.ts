import { ref, computed, onMounted, onUnmounted, watchEffect } from 'vue';
import { usePage, useForm } from '@inertiajs/vue3';
import { LayoutGrid, Inbox, Info, Settings, LogOut, FileSearch, Users, Send, Compass, CalendarClock} from 'lucide-vue-next';
import { MenuItem } from '@/types';

export function useAppLayout() {
    const page = usePage();
    const currentRoute = computed(() => {
        // Access page.url to trigger re-computation on navigation.
        /* eslint-disable @typescript-eslint/no-unused-vars */
        const url = page.url;
        /* eslint-enable @typescript-eslint/no-unused-vars */
        return route().current();
    });
    
    // Menu items
    const menuItems = computed<MenuItem[]>(() => [
        {
            label: 'Beranda',
            lucideIcon: LayoutGrid,
            route: route('dashboard'),
            active: currentRoute.value == 'dashboard',
        },
        {
            label: 'Rapat',
            lucideIcon: CalendarClock,
            route: route('meetings.index'),
            isActive: route().current('meetings.*'),
        },
        {
            label: 'Surat Masuk',
            lucideIcon: Inbox,
            route: route('surat-masuk.index'),
            active: currentRoute.value == 'users',
            visible: page.props.auth.permissions.includes('surat-masuk-index'),
        },
        {
            label: 'Surat Keluar',
            lucideIcon: Send,
            route: route('surat-keluar.index'),
            active: currentRoute.value == 'surat-keluar',
            visible: page.props.auth.permissions.includes('surat-keluar-index'),
        },
        {
            label: 'Surat Tugas',
            lucideIcon: Compass,
            route: route('surat-tugas.index'),
            active: currentRoute.value == 'surat-tugas',
            visible: page.props.auth.permissions.includes('surat-tugas-index'),
        },
        {
            label: 'Pengguna',
            lucideIcon: Users,
            route: route('users.index'),
            active: currentRoute.value == 'users',
            visible: page.props.auth.permissions.includes('user-index'),
        },
        // {
        //     label: '#',
        //     lucideIcon: Info,
        //     items: [
        //         {
        //             label: 'Starter Kit Docs',
        //             url: 'https://connorabbas.github.io/laravel-primevue-starter-kit-docs/',
        //             target: '_blank',
        //             lucideIcon: FileSearch,
        //         },
        //     ],
        // },
    ]);

    // User menu and logout functionality.
    const logoutForm = useForm({});
    const logout = () => {
        logoutForm.post(route('logout'));
    };
    const userMenuItems: MenuItem[] = [
        {
            label: 'Settings',
            route: route('profile.edit'),
            lucideIcon: Settings,
        },
        {
            separator: true
        },
        {
            label: 'Log out',
            lucideIcon: LogOut,
            command: () => logout(),
        },
    ];

    // Mobile menu
    const mobileMenuOpen = ref(false);
    if (typeof window !== 'undefined') {
        const windowWidth = ref(window.innerWidth);
        const updateWidth = () => {
            windowWidth.value = window.innerWidth;
        };
        onMounted(() => {
            window.addEventListener('resize', updateWidth);
        });
        onUnmounted(() => {
            window.removeEventListener('resize', updateWidth);
        });
        watchEffect(() => {
            if (windowWidth.value > 1024) {
                mobileMenuOpen.value = false;
            }
        });
    }

    return {
        currentRoute,
        menuItems,
        userMenuItems,
        mobileMenuOpen,
        logout,
    };
}
