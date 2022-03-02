# web-crawler



## How does it works?

Basically, assume that we give crawler a URL to start with:

`#url`

then something like this happens:


+ Starting script:


```shell
#url
├─────── #url_1
├─────── #url_2
└─────── #url_3
```

+ First iteration:

```shell
#url
├─────── #url_1
├─────── #url_2
└─────── #url_3
```


+ Second iteration:

```shell
#url
├─────── #url_1
│           ├─────── #url_1_1
│           └─────── #url_1_2
├─────── #url_2
│           ├─────── #url_2_1
│           ├─────── #url_2_2
│           └─────── #url_2_3
└─────── #url_3
            └─────── #url_3_1

```

+ Third iteration:

```shell
#url
├─────── #url_1
│           ├─────── #url_1_1
│           │           ├─────── #url_1_1_1
│           │           ├─────── #url_1_1_2
│           │           └─────── #url_1_1_3
│           └─────── #url_1_2
├─────── #url_2
│           ├─────── #url_2_1
│           ├─────── #url_2_2
│           │           ├─────── #url_2_2_1
│           │           ├─────── #url_2_2_2
│           │           ├─────── #url_2_2_3
│           │           └─────── #url_2_2_4
│           └─────── #url_2_3
└─────── #url_3
            └─────── #url_3_1
                        ├─────── #url_3_1_1
                        └─────── #url_3_1_2

```



and it keeps rolling that way.

Every time, it processes the current depth's URLs , like a `Breadth-first search` in a tree.


You can set limitation for number of fetched URLs per URL , like a `Max-degree` in a tree.   
