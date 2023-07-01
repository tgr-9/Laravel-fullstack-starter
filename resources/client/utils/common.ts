export function logger(...args: any) {
  if (import.meta.env.DEV)
    console.log.apply(null, args) // eslint-disable-line no-console
}
