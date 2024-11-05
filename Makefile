### Pre-commit hooks ###
pre-commit-all: pre-commit-fix pre-commit-lint pre-commit-phpcs pre-commit-phpmnd pre-phpstan

pre-commit-fix:
	git diff --diff-filter=AM --name-only --cached app tests database routes \
	| grep ".php" \
	| xargs ./vendor/bin/phpcbf --standard=phpcs.xml

pre-commit-phpcs:
	git diff --diff-filter=AM --name-only --cached app tests database routes \
	| grep ".php" \
	| xargs ./vendor/bin/phpcs --standard=phpcs.xml

pre-commit-phpmnd:
	git diff --diff-filter=AM --name-only --cached app tests database routes \
	| grep ".php" \
	| xargs ./vendor/bin/phpmnd

pre-commit-lint:
	git diff --diff-filter=AM --name-only --cached app tests database routes \
	| grep ".php" \
	| xargs ./vendor/bin/parallel-lint

pre-phpstan:
	git diff --diff-filter=AM --name-only --cached app tests database routes \
	| grep ".php" \
	| xargs ./vendor/bin/phpstan analyse

