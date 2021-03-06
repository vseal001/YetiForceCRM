/**
 * Helper methods
 *
 * @description Helper methods
 * @license YetiForce Public License 3.0
 * @author Tomasz Poradzewski <t.poradzewski@yetiforce.com>
 */
export function getGroupIcon(roomType) {
	switch (roomType) {
		case 'crm':
			return 'yfi-favorite-room'
		case 'group':
			return 'yfi-group-room'
		case 'global':
			return 'yfi-global-room'
	}
}

/**
 * Helper function to merge multiple objects with reactivity enabled
 *
 * @param   {object}  target target object
 * @param   {object[]}  source objects
 *
 * @return  {object}  merged object
 */
export function mergeDeepReactive(target, ...sources) {
	if (!sources.length) {
		return Vue.observable(target)
	}
	const isObject = item => {
		return item && typeof item === 'object' && !Array.isArray(item)
	}
	const source = sources.shift()
	if (isObject(target) && isObject(source)) {
		for (const key in source) {
			if (isObject(source[key])) {
				if (typeof target[key] === 'undefined') {
					Vue.set(target, key, {})
				}
				mergeDeepReactive(target[key], source[key])
			} else {
				Vue.set(target, key, source[key])
			}
		}
	}
	return mergeDeepReactive(target, ...sources)
}
