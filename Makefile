# install phpunit globally for Windows
# https://chocolatey.org/install
# choco install make
test-win:
	phpunit --verbose tests

# default tests
test:
	./vendor/bin/phpunit

# separate Docker internal, external, mixed commands