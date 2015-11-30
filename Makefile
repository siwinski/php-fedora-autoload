NAME=php-fedora-autoload
VERSION=1.0.0

default:
	rm -rf ${NAME}-${VERSION}
	mkdir ${NAME}-${VERSION}
	cp -pr LICENSE *.md composer.json phpunit.xml.dist src tests ${NAME}-${VERSION}
	tar -cvzf `rpm --eval='%{_sourcedir}'`/${NAME}.tar.gz ${NAME}-${VERSION}
	rm -rf ${NAME}-${VERSION}
	rpmbuild -ba ./${NAME}.spec
