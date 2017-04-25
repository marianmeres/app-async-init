.PHONY: js
js: src/app-async-init.min.js src/app-callback-stack.min.js

src/app-async-init.min.js: src/app-async-init.js
	@uglifyjs2 src/app-async-init.js -m -o src/app-async-init.min.js

src/app-callback-stack.min.js: src/app-callback-stack.js
	@uglifyjs2 src/app-callback-stack.js -m -o src/app-callback-stack.min.js

