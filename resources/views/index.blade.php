<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laravel Route Visualizer</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-50 text-gray-800 p-8">
    <h1 class="text-3xl font-bold mb-6">Laravel Route Visualizer</h1>
    <div
        x-data="routeTableComponent(window.groupedRoutes)"
        x-init="init()"
        class="p-6 bg-white rounded shadow mb-8"
    >
        <!-- Filter UI - static version -->
        <div class="p-6 bg-white rounded shadow mb-8">
            <h2 class="text-xl font-semibold mb-4">Filter Routes</h2>
            <!-- HTTP Methods -->
            <div class="mb-4">
                <h3 class="font-medium mb-1">HTTP Methods:</h3>
                <div class="flex flex-wrap gap-4">
                    <template x-for="method in availableMethods" :key="method">
                        <label class="inline-flex items-center space-x-2">
                            <input type="checkbox" :value="method" x-model="selectedMethods">
                            <span x-text="method"></span>
                        </label>
                    </template>
                </div>
            </div>
            <!-- Middleware -->
            <div class="mb-4">
                <h3 class="font-medium mb-1">Middleware:</h3>
                <div class="flex flex-wrap gap-4">
                    <template x-for="mw in availableMiddleware" :key="mw">
                        <label class="inline-flex items-center space-x-2">
                            <input type="checkbox" :value="mw" x-model="selectedMiddleware">
                            <span x-text="mw"></span>
                        </label>
                    </template>
                </div>
            </div>
            <!-- Search Box -->
            <div class="mt-2">
            <input
                type="text"
                placeholder="Search URI, name, action..."
                class="w-full px-3 py-2 border border-gray-300 rounded"
                x-model.debounce.300ms="search"
            />
            </div>
        </div>   
        <!-- Routes Table -->
        <template x-if="Object.keys(filteredRoutes).length > 0">
            <template x-for="(routes, group) in filteredRoutes" :key="group">
                <div class="mt-10">
                    <h2 class="text-xl font-semibold mb-4 border-b pb-2" x-text="group + ' Routes'"></h2>

                    <!-- Scrollable Table Container -->
                    <div class="overflow-x-auto">
                        <div class="max-h-[500px] overflow-y-auto rounded-lg border border-gray-200">
                            <table class="w-full table-auto border-collapse bg-white">
                                <thead class="bg-gray-100 text-left sticky top-0 z-10">
                                    <tr>
                                        <th class="px-4 py-2 border-b">Method</th>
                                        <th class="px-4 py-2 border-b">URI</th>
                                        <th class="px-4 py-2 border-b">Name</th>
                                        <th class="px-4 py-2 border-b">Action</th>
                                        <th class="px-4 py-2 border-b">Middleware</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template x-for="(route, index) in routes" :key="index">
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 border-b font-mono text-sm text-blue-600" x-text="route.method"></td>
                                            <td class="px-4 py-2 border-b font-mono text-sm" x-text="route.uri"></td>
                                            <td class="px-4 py-2 border-b font-mono text-sm text-gray-500" x-text="route.name || '-'"></td>
                                            <td class="px-4 py-2 border-b font-mono text-sm" x-text="route.action"></td>
                                            <td class="px-4 py-2 border-b font-mono text-sm text-gray-600" x-text="route.middleware"></td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </template>
        </template>
        <template x-if="Object.keys(filteredRoutes).length === 0">
            <p class="text-gray-600">No routes match your filters.</p>
        </template>
    </div>
</body>
<script>
    window.groupedRoutes = @json($groupedRoutes);
</script>
<script>
    function routeTableComponent(groupedRoutes) {
        return {
            routes: groupedRoutes || {}, // original input
            filteredRoutes: {},
            availableMethods: [],
            availableMiddleware: [],
            selectedMethods: [],
            selectedMiddleware: [],
            search: '',

            init() {
                this.extractFilterOptions();
                this.applyFilters();
                this.$watch('selectedMethods', () => this.applyFilters());
                this.$watch('selectedMiddleware', () => this.applyFilters());
                this.$watch('search', () => this.applyFilters());
            },

            extractFilterOptions() {
                const methodSet = new Set();
                const middlewareSet = new Set();

                Object.values(this.routes).flat().forEach(route => {
                    route.method.split('|').forEach(m => methodSet.add(m.trim()));
                    route.middleware.split(',').forEach(mw => {
                        if (mw.trim()) middlewareSet.add(mw.trim());
                    });
                });

                this.availableMethods = [...methodSet].sort();
                this.availableMiddleware = [...middlewareSet].sort();
            },

            applyFilters() {
                if (!this.routes || typeof this.routes !== 'object') return;
                const searchLower = (this.search || '').toLowerCase();
                this.filteredRoutes = {};

                Object.entries(this.routes).forEach(([group, routes]) => {
                    const filtered = routes.filter(route => {
                        const matchesMethod = this.selectedMethods.length === 0 || route.method.split('|').some(m => this.selectedMethods.includes(m.trim()));
                        const matchesMiddleware = this.selectedMiddleware.length === 0 || route.middleware.split(',').some(mw => this.selectedMiddleware.includes(mw.trim()));
                        const matchesSearch = [route.uri, route.name, route.action].some(field =>
                            field?.toLowerCase().includes(searchLower)
                        );

                        return matchesMethod && matchesMiddleware && matchesSearch;
                    });

                    if (filtered.length > 0) {
                        this.filteredRoutes[group] = filtered;
                    }
                });
            },
        };
    }
</script>
</html>
