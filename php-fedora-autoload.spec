#
# Fedora spec file for php-fedora-autoload
#
# Copyright (c) 2015 Shawn Iwinski <shawn@iwin.ski>
#
# License: MIT
# http://opensource.org/licenses/MIT
#
# Please preserve changelog entries
#

%global github_owner     xxxxx
%global github_name      xxxxx
%global github_version   1.0.0
%global github_commit    xxxxx

%global composer_vendor  fedora
%global composer_project autoload

# "php": ">= 5.3.3"
%global php_min_ver 5.3.3
# "symfony/class-loader": "^2.3"
%global symfony_min_ver 2.3
%global symfony_max_ver 3.0
# "zendframework/zend-loader": "^2.4"
%global zend_min_ver 2.4
%global zend_max_ver 3.0

# Build using "--without tests" to disable tests
%global with_tests 0%{!?_without_tests:1}

%{!?phpdir:  %global phpdir  %{_datadir}/php}

Name:          php-%{composer_vendor}-%{composer_project}
Version:       %{github_version}
Release:       1%{?github_release}%{?dist}
Summary:       Fedora Autoload

Group:         Development/Libraries
License:       MIT
URL:           https://github.com/%{github_owner}/%{github_name}
#Source0:       %%{url}/archive/%%{github_commit}/%%{name}-%%{github_version}-%%{github_commit}.tar.gz
Source0:       php-fedora-autoload.tar.gz

BuildArch:     noarch
# Tests
%if %{with_tests}
## composer.json
BuildRequires: php(language)                           >= %{php_min_ver}
BuildRequires: php-composer(phpunit/phpunit)
BuildRequires: php-composer(symfony/class-loader)      >= %{symfony_min_ver}
BuildRequires: php-composer(zendframework/zend-loader) >= %{zend_min_ver}
## phpcompatinfo (computed from version 1.0.0)
BuildRequires: php-spl
%endif

# composer.json
Requires:      php(language) >= %{php_min_ver}

# All sub-packages
Requires:      php-composer(%{composer_vendor}/%{composer_project}-common)  = %{version}
Requires:      php-composer(%{composer_vendor}/%{composer_project}-symfony) = %{version}
Requires:      php-composer(%{composer_vendor}/%{composer_project}-zend)    = %{version}

# Composer
Provides:      php-composer(%{composer_vendor}/%{composer_project}) = %{version}

%description
%{summary}.

# ------------------------------------------------------------------------------

%package  common

Summary:  Fedora Autoload: Common

# phpcompatinfo (computed from version 1.0.0)
#     <none>

# Composer
Provides: php-composer(%{composer_vendor}/%{composer_project}-common) = %{version}

%description common
%{summary}.

# ------------------------------------------------------------------------------

%package  symfony

Summary:  Fedora Autoload: Symfony

Requires: php-composer(%{composer_vendor}/%{composer_project}-common) =  %{version}
Requires: php-composer(symfony/class-loader)                          >= %{symfony_min_ver}
Requires: php-composer(symfony/class-loader)                          <  %{symfony_max_ver}
# phpcompatinfo (computed from version 1.0.0)
Requires: php-spl

# Composer
Provides: php-composer(%{composer_vendor}/%{composer_project}-symfony) = %{version}

%description symfony
%{summary}.

# ------------------------------------------------------------------------------

%package  zend

Summary:  Fedora Autoload: Zend

Requires: php-composer(%{composer_vendor}/%{composer_project}-common) =  %{version}
Requires: php-composer(zendframework/zend-loader)                     >= %{zend_min_ver}
Requires: php-composer(zendframework/zend-loader)                     <  %{zend_max_ver}
# phpcompatinfo (computed from version 1.0.0)
#     <none>

# Composer
Provides: php-composer(%{composer_vendor}/%{composer_project}-zend) = %{version}

%description zend
%{summary}.

# ------------------------------------------------------------------------------

%prep
#%%setup -qn %%{github_name}-%%{github_commit}
%setup


%build
# Empty build section, nothing to build


%install
mkdir -p %{buildroot}%{phpdir}/Fedora/Autoload/Test
cp -rp src/* %{buildroot}%{phpdir}/Fedora/Autoload/
cp -rp tests/* %{buildroot}%{phpdir}/Fedora/Autoload/Test/

: Symlink main package docs to common sub-package docs
mkdir -p %{buildroot}%{_docdir}
%if 0%{?fedora} >= 20
ln -s %{name}-common %{buildroot}%{_docdir}/%{name}
%else
ln -s %{name}-common-%{version} %{buildroot}%{_docdir}/%{name}-%{version}
%endif


%check
%if %{with_tests}
: Create tests bootstrap
cat <<'BOOTSTRAP' | tee bootstrap.php
<?php

require_once '%{buildroot}%{phpdir}/Fedora/Autoload/Symfony.php';
\Fedora\Autoload\Symfony::getInstance()
    ->addPrefix('Fedora\\Autoload\\', '%{buildroot}%{phpdir}');
AUTOLOAD

%{_bindir}/phpunit --verbose
%else
: Tests skipped
%endif


%{!?_licensedir:%global license %%doc}

%files
%if 0%{?fedora} >= 20
%doc %{_docdir}/%{name}
%else
%doc %{_docdir}/%{name}-%{version}
%endif

%files common
%license LICENSE
%doc *.md
%doc composer.json
%dir %{phpdir}/Fedora
%dir %{phpdir}/Fedora/Autoload
     %{phpdir}/Fedora/Autoload/Common.php
%exclude %{phpdir}/Fedora/Autoload/Test

%files symfony
%{phpdir}/Fedora/Autoload/Symfony.php

%files zend
%{phpdir}/Fedora/Autoload/Zend.php


%changelog
* Mon Nov 30 2015 Shawn Iwinski <shawn@iwin.ski> - 1.0.0-1
- Initial package
