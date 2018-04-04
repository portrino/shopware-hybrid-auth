#!/usr/bin/env bash

commit=$1
if [ -z ${commit} ]; then
    commit=$(git tag --sort=-creatordate | head -1)
    if [ -z ${commit} ]; then
        commit="master";
    fi
fi

# Remove old release
rm -rf Port1HybridAuth Port1HybridAuth-*.zip

# Build new release
mkdir -p Port1HybridAuth
git archive ${commit} | tar -x -C Port1HybridAuth
composer install --no-dev -n -o -d Port1HybridAuth
zip -r Port1HybridAuth-${commit}.zip Port1HybridAuth
