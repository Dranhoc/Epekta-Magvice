export default {
    root: ({ props }) => ({
        class: [
            'relative',
            '[&>input]:w-full',

            '[&>*:first-child]:absolute',
            '[&>*:first-child]:h-full',
            '[&>*:first-child]:w-12',
            '[&>*:first-child]:bg-surface-200',
            '[&>*:first-child]:rounded-l-md',
            '[&>*:first-child]:border-surface-300',
            '[&>*:first-child]:border',
            '[&>*:first-child]:flex',
            '[&>*:first-child]:items-center',
            '[&>*:first-child]:justify-center',
            '[&>*:first-child]:top-0',
            '[&>*:first-child]:leading-none',
            '[&>*:first-child]:text-surface-900/60 dark:[&>*:first-child]:text-white/60',
            {
                '[&>*:last-child]:pr-14': props?.ptOptions?.position === 'right',
                '[&>*:last-child]:pl-14': props?.ptOptions?.position === 'left'
            }
        ]
    })
};
