export const install: AppModuleInstall = ({ isClient }): void => {
  if (!isClient && !import.meta.env.VITE_GTM_ID)
    return

  const dataLayer = window.dataLayer || []
  const gtag = window.gtag = (...args) => dataLayer.push(args)

  gtag('js', new Date())
  gtag('config', import.meta.env.VITE_GTM_ID)
}

declare global {
  interface Window {
    dataLayer: any[]
    gtag: (...args: unknown[]) => number
  }
}
