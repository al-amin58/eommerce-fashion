

export function registerLayouts(app) {
    const layouts = import.meta.glob('./Pages/**/*.vue', { eager: false })

    Object.entries(layouts).forEach(([, layout]) => {
        app.component(layout?.default?.name, layout?.default);
    });
}
