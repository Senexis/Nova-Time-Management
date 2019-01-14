Nova.booting((Vue, router, store) => {
    router.addRoutes([
        {
            name: 'tracked-timesheets',
            path: '/tracked-timesheets',
            component: require('./components/Tool'),
        },
    ])
})
