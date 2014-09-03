# Profiler

Profiler is alternative take on DB profiling compared to
[https://github.com/amoebas/silverstripe-dbprofiler](dbprofiler). It's requires
a patch to the SilverStripe core DB class to be able to intercept queries sent
to the database.

Another difference is that the profiling result is displayed on /dev/profiler
instead of inline at the bottom.

Duplicate queries are color coded on the list at /dev/profiler with a number
that corresponds to the total number of duplicates on the page.

That said, it's purely a playground for profiling and is most likely there are
bugs and weird features.

# Installation 3.*

    git clone git://github.com/amoebas/silverstripe-profiler.git profiler
    ./profiler/patches/patch-core.sh

Load a page in your browser with ?flush=1

# Installation 2.4

    git clone git://github.com/amoebas/silverstripe-profiler.git profiler
    cd profiler && git checkout 2.4
    cd ../
    ./sapphire/sake dev/build
    ./profiler/patches/patch-core.sh

Load a page in your browser with ?flush=1

# Usage

- Go to this url: dev/profiler
