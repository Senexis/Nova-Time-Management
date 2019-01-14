Nova.booting((Vue, router, store) => {
    router.addRoutes([
        {
            name: 'timesheet-reports',
            path: '/timesheet-reports',
            component: require('./components/Tool'),
        },
    ])
})
