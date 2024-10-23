export default (callback: any, delay: number) => {
	let timeout: any;

	return (...args: any) => {
		if (timeout) {
			clearTimeout(timeout);
		}

		timeout = setTimeout(() => {
			callback(...args);
		}, delay);
	};
};
