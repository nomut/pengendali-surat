import { ref, computed, onMounted, onUnmounted, watchEffect } from 'vue';
import { usePage, useForm } from '@inertiajs/vue3';
import { LayoutGrid, Settings, LogOut, FileSearch, Users } from 'lucide-vue-next';
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
    const isCurrentRoute = (pattern: string) => {
        // Access currentRoute to trigger re-computation on navigation.
        void currentRoute.value;
        return route().current(pattern) ?? false;
    };
    const menuItems = computed<MenuItem[]>(() => [
        {
            label: 'Beranda',
            lucideIcon: LayoutGrid,
            route: route('dashboard'),
            active: isCurrentRoute('dashboard'),
        },
        {
            label: 'CMS Halaman',
            lucideIcon: FileSearch,
            route: route('cms.index'),
            active: isCurrentRoute('cms.*'),
            visible: page.props.auth.permissions.includes('cms-index'),
        },
        {
            label: 'Kegiatan',
            lucideIcon: LayoutGrid,
            route: route('activities.index'),
            active: isCurrentRoute('activities.*'),
            visible: page.props.auth.permissions.includes('activity-index'),
        },
        {
            label: 'Galeri',
            lucideIcon: LayoutGrid,
            route: route('galleries.index'),
            active: isCurrentRoute('galleries.*'),
            visible: true,
        },
        {
            label: 'Pengguna',
            lucideIcon: Users,
            route: route('users.index'),
            active: isCurrentRoute('users.*'),
            visible: page.props.auth.permissions.includes('user-index'),
        },
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
