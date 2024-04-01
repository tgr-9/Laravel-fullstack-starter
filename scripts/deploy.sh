#!/usr/bin/env bash

if [ $# -eq 0 ]; then
    echo "Usage: [mode] is requried" 1>&2
    exit 1
fi

declare -A modes
modes["staging"]="main"

if [[ ! -v modes[$1] ]]; then
    echo "Only mode staging or develop are supported" 1>&2
    exit 1
fi

tmp_dir='storage/deploy-tmp'
mode="$1"
branch="${modes[$1]}"

echo "building ${mode} for ${branch}"

pnpm build --mode $mode

find $tmp_dir -depth 1 ! -name .git ! -name $tmp_dir -exec rm -rf {} +

git archive --format tar --prefix deploy-tmp/ HEAD | (cd storage && tar xf -)

rsync -av --exclude='*.map' public/build $tmp_dir/public/

cd $tmp_dir

if [[ -f public/.gitignore ]]; then
    rm public/.gitignore
fi

git checkout $branch --force
git add -A && git commit -sm "chore: update $(date +'%Y-%m-%d')"
git push origin -u $branch:$branch

cd -
