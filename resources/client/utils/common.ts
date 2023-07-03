/**
 * A `console.log(...args)` wrapper that should only work while development.
 * @param args
 */
export function logger(...args: any) {
  if (import.meta.env.DEV)
    console.log.apply(null, args) // eslint-disable-line no-console
}
