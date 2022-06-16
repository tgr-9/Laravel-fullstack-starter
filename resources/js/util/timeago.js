import { format, formatDistanceToNow, parseISO } from 'date-fns'

let locale

/**
 * @credits https://github.com/marcreichel/alpine-timeago
 */
export function TimeAgo(Alpine) {
  Alpine.directive('datetime', (el, { expression, modifiers }, { evaluateLater, effect }) => {
    const evaluate = evaluateLater(expression)

    const render = (date) => {
      try {
        if (typeof date === 'string')
          date = parseISO(date)

        el.setAttribute('title', date)
        el.textContent = format(date, 'yyyy-MM-dd HH:mm:ss', {
          addSuffix: !modifiers.includes('pure'),
          locale,
        })
      }
      catch (e) {
        console.error(e)
      }
    }

    effect(() => {
      evaluate(render)
    })
  })

  Alpine.directive('date', (el, { expression, modifiers }, { evaluateLater, effect }) => {
    const evaluate = evaluateLater(expression)

    const render = (date) => {
      try {
        if (typeof date === 'string')
          date = parseISO(date)

        el.setAttribute('title', date)
        el.textContent = format(date, 'yyyy-MM-dd', {
          addSuffix: !modifiers.includes('pure'),
          locale,
        })
      }
      catch (e) {
        console.error(e)
      }
    }

    effect(() => {
      evaluate(render)
    })
  })

  Alpine.directive('time', (el, { expression, modifiers }, { evaluateLater, effect }) => {
    const evaluate = evaluateLater(expression)

    const render = (date) => {
      try {
        if (typeof date === 'string')
          date = parseISO(date)

        el.setAttribute('title', date)
        el.textContent = format(date, 'HH:mm:ss', {
          addSuffix: !modifiers.includes('pure'),
          locale,
        })
      }
      catch (e) {
        console.error(e)
      }
    }

    effect(() => {
      evaluate(render)
    })
  })

  Alpine.directive('timeago', (el, { expression, modifiers }, { evaluateLater, effect, cleanup }) => {
    const evaluateDate = evaluateLater(expression)

    const render = (date) => {
      try {
        if (typeof date === 'string')
          date = parseISO(date)

        el.setAttribute('title', date)
        el.textContent = formatDistanceToNow(date, {
          addSuffix: !modifiers.includes('pure'),
          locale,
        })
      }
      catch (e) {
        console.error(e)
      }
    }

    let interval

    effect(() => {
      evaluateDate((date) => {
        if (interval)
          clearInterval(interval)

        render(date)

        interval = setInterval(() => {
          render(date)
        }, 30000)
      })
    })

    cleanup(() => clearInterval(interval))
  })
}

TimeAgo.configure = (config) => {
  if (!!config.locale && !!config.locale.formatDistance)
    locale = config.locale

  return TimeAgo
}

export default TimeAgo
