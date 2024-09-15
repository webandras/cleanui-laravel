@extends('admin.layouts.demo')

@section('content')

    <main>
        <div class="padding-1-5">
            @if (session('status'))
                <div class="pale-green border border-green round" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <h1 class="margin-top-0">Clean.UI</h1>


            <h2 class="text-gray-60 semibold">COMPONENTS</h2>


            <h3>1. Accordion</h3>
            <p>Just because you have the emotional range of a teaspoon doesn’t mean we all have.</p>

            <div class="accordion" x-data="accordionData">

                <button @click="toggleAccordion('accordionOne')" aria-controls="accordionOne" type="button"
                        class="fs-16 block left-align accordion-button">
                    <span>Open Section 1</span><i class="fa-solid fa-minus"></i>
                </button>
                <div id="accordionOne" :aria-expanded="isAccordionContentExpanded('accordionOne')"
                     class="hide accordion-item show">
                    <div class="box">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                            labore
                            et
                            dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi
                            ut
                            aliquip ex
                            ea commodo consequat.</p>
                    </div>
                </div>

                <button @click="toggleAccordion('accordionTwo')" aria-controls="accordionTwo" type="button"
                        class="fs-16 block left-align">
                    <span>Open Section 2</span><i class="fa-solid fa-plus"></i>
                </button>
                <div id="accordionTwo" :aria-expanded="isAccordionContentExpanded('accordionTwo')"
                     class="hide bar-block accordion-item">
                    <a class="bar-item" href="#">Link 1</a>
                    <a class="bar-item" href="#">Link 2</a>
                    <a class="bar-item" href="#">Link 3</a>
                </div>

                <button @click="toggleAccordion('accordionThree')" aria-controls="accordionThree" type="button"
                        class="fs-16 block left-align">
                    <span>Open Section 3</span><i class="fa-solid fa-plus"></i>
                </button>
                <div id="accordionThree" :aria-expanded="isAccordionContentExpanded('accordionThree')"
                     class="hide black accordion-item">
                    <div class="box">
                        <p>Accordion with Images:</p>
                        <img src="{{ url('/images/img_snowtops.jpg') }}"
                             class="animate-zoom thumbnail-third" alt="French Alps">
                        <p>French Alps</p>
                    </div>
                </div>
            </div>

            <h4>Example:</h4>
            <pre><code class="language-html">&lt;div class=&quot;accordion&quot; x-data=&quot;accordionData&quot;&gt;
    &lt;button @click=&quot;toggleAccordion('accordionOne')&quot; class=&quot;block left-align accordion-button&quot;&gt;
        &lt;span&gt;Open Section 1&lt;/span&gt;&lt;i class=&quot;fa-solid fa-plus&quot;&gt;&lt;/i&gt;
    &lt;/button&gt;
    &lt;div id=&quot;accordionOne&quot; class=&quot;hide accordion-item show&quot;&gt;
        &lt;div class=&quot;box&quot;&gt;
            &lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                labore
                et
                dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi
                ut
                aliquip ex
                ea commodo consequat.&lt;/p&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    &lt;button @click=&quot;toggleAccordion('accordionTwo')&quot; class=&quot;block left-align&quot;&gt;
        &lt;span&gt;Open Section 2&lt;/span&gt;&lt;i class=&quot;fa-solid fa-plus&quot;&gt;&lt;/i&gt;
    &lt;/button&gt;
    &lt;div id=&quot;accordionTwo&quot; class=&quot;hide bar-block accordion-item&quot;&gt;
        &lt;a class=&quot;bar-item&quot; href=&quot;javascript:void(0)&quot;&gt;Link 1&lt;/a&gt;
        &lt;a class=&quot;bar-item&quot; href=&quot;javascript:void(0)&quot;&gt;Link 2&lt;/a&gt;
        &lt;a class=&quot;bar-item&quot; href=&quot;javascript:void(0)&quot;&gt;Link 3&lt;/a&gt;
    &lt;/div&gt;
    &lt;button @click=&quot;toggleAccordion('accordionThree')&quot; class=&quot;block left-align&quot;&gt;
        &lt;span&gt;Open Section 3&lt;/span&gt;&lt;i class=&quot;fa-solid fa-plus&quot;&gt;&lt;/i&gt;
    &lt;/button&gt;
    &lt;div id=&quot;accordionThree&quot; class=&quot;hide black accordion-item&quot;&gt;
        &lt;div class=&quot;box&quot;&gt;
            &lt;p&gt;Accordion with Images:&lt;/p&gt;
            &lt;img src=&quot;{{ url('/images/img_snowtops.jpg') }}&quot;
                 class=&quot;animate-zoom thumbnail-third&quot; alt=&quot;French Alps&quot;&gt;
            &lt;p&gt;French Alps&lt;/p&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>


            <hr>


            <h3>2. Alert</h3>
            <p>The <a href="#">alert</a>
                class can also be used for all kinds of alerts:</p>
            <div x-data="alertData" x-show="openAlert" role="alert" class="alert danger relative">
                <button @click="hideAlert()" class="close-button topright">
                    <i class="fa-solid fa-xmark"></i>
                </button>
                <div class="h5 bold text-black"><i class="fa-solid fa-circle-exclamation margin-right-0-5"></i>Danger!
                </div>
                <p class="alert-message">Red often indicates a dangerous or negative situation.</p>
            </div>

            <div x-data="alertData" x-show="openAlert" role="alert" class="alert warning relative">
                <div class="h5 bold"><i class="fa-solid fa-triangle-exclamation margin-right-0-5"></i>Warning!</div>
                <p class="alert-message">Yellow often indicates a warning that might need attention.</p>
            </div>

            <div x-data="alertData" x-show="openAlert" role="status" class="alert success relative">
                <div class="h5 bold"><i class="fa-solid fa-circle-check margin-right-0-5"></i>Success!</div>
                <p class="alert-message">Green often indicates something successful or positive.</p>
            </div>

            <div x-data="alertData" x-show="openAlert" role="alert" class="alert info relative">
                <div class="h5 bold"><i class="fa-solid fa-circle-info margin-right-0-5"></i>Info!</div>
                <p class="alert-message">Blue often indicates a neutral informative change or action.</p>
            </div>

            <h4>Example:</h4>
            <pre><code class="language-html">&lt;div x-data=&quot;alertData&quot; x-show=&quot;openAlert&quot;
     class=&quot;alert danger relative&quot;&gt;
    &lt;button @click=&quot;hideAlert()&quot; class=&quot;close-button topright&quot;&gt;
        &lt;i class=&quot;fa-solid fa-xmark&quot;&gt;&lt;/i&gt;
    &lt;/button&gt;
    &lt;div class=&quot;h5 bold text-black&quot;&gt;&lt;i class=&quot;fa-solid fa-circle-exclamation margin-right-0-5&quot;&gt;&lt;/i&gt;Danger!
    &lt;/div&gt;
    &lt;p class=&quot;alert-message&quot;&gt;Red often indicates a dangerous or negative situation.&lt;/p&gt;
&lt;/div&gt;

&lt;div x-data=&quot;alertData&quot; x-show=&quot;openAlert&quot;
     class=&quot;alert warning relative&quot;&gt;
    &lt;button @click=&quot;hideAlert()&quot; class=&quot;close-button topright&quot;&gt;
        &lt;i class=&quot;fa-solid fa-xmark&quot;&gt;&lt;/i&gt;
    &lt;/button&gt;
    &lt;div class=&quot;h5 bold&quot;&gt;&lt;i class=&quot;fa-solid fa-triangle-exclamation margin-right-0-5&quot;&gt;&lt;/i&gt;Warning!&lt;/div&gt;
    &lt;p class=&quot;alert-message&quot;&gt;Yellow often indicates a warning that might need attention.&lt;/p&gt;
&lt;/div&gt;

&lt;div x-data=&quot;alertData&quot; x-show=&quot;openAlert&quot;
     class=&quot;alert success relative&quot;&gt;
    &lt;button @click=&quot;hideAlert()&quot; class=&quot;close-button topright&quot;&gt;
        &lt;i class=&quot;fa-solid fa-xmark&quot;&gt;&lt;/i&gt;
    &lt;/button&gt;
    &lt;div class=&quot;h5 bold&quot;&gt;&lt;i class=&quot;fa-solid fa-circle-check margin-right-0-5&quot;&gt;&lt;/i&gt;Success!&lt;/div&gt;
    &lt;p class=&quot;alert-message&quot;&gt;Green often indicates something successful or positive.&lt;/p&gt;
&lt;/div&gt;

&lt;div x-data=&quot;alertData&quot; x-show=&quot;openAlert&quot;
     class=&quot;alert info relative&quot;&gt;
    &lt;button @click=&quot;hideAlert()&quot; class=&quot;close-button topright&quot;&gt;
        &lt;i class=&quot;fa-solid fa-xmark&quot;&gt;&lt;/i&gt;
    &lt;/button&gt;
    &lt;div class=&quot;h5 bold&quot;&gt;&lt;i class=&quot;fa-solid fa-circle-info margin-right-0-5&quot;&gt;&lt;/i&gt;Info!&lt;/div&gt;
    &lt;p class=&quot;alert-message&quot;&gt;Blue often indicates a neutral informative change or action.&lt;/p&gt;
&lt;/div&gt;</code></pre>


            <hr>


            <h3>3. Badge</h3>
            <p>The <a href="#">badge</a>
                classes are capable of displaying all kinds of tags, labels, badges and signs:</p>
            <p><span class="badge fs-14 circle gray-60 text-white">2</span>
                <span class="badge fs-14 circle primary text-white">8</span>
                <span class="badge fs-14 circle red text-white">A</span>
                <span class="badge fs-14 circle accent">B</span>
            </p>

            <p><span class="badge fs-14 gray-60">New</span>
                <span class="badge fs-14 accent">Warning</span>
                <span class="badge fs-14 red">Danger</span>
                <span class="badge fs-14 blue">Info</span>
            </p>

            <div class="row-padding">
                <div class="half margin-bottom-1">
                    <div class="badge round green margin-bottom-1">
                        <div class="badge round green">Falcon Ridge Parkway</div>
                    </div>
                    <div>
                        <div class="badge fs-64 red">S</div>
                        <div class="badge fs-64 black">A</div>
                        <div class="badge fs-64 orange">L</div>
                        <div class="badge fs-64 blue">E</div>
                    </div>
                </div>

                <div class="half">
                    <div class="badge fs-24 padding-large round-large red center">DO NOT<br>
                        BREATHE<br>UNDER WATER
                    </div>
                </div>
            </div>


            <hr>


            <h3>4. Bar (navbar)</h3>
            <p>The <b>bar</b> class can be used to create a horizontal bar:
            </p>

            <div class="bar">
                <a href="javascript:void(0)" class="bar-item">Home</a>
                <a href="javascript:void(0)" class="bar-item">Link 1</a>
                <a href="javascript:void(0)" class="bar-item">Link 2</a>
                <a href="javascript:void(0)" class="bar-item hide-mobile">Link 3</a>
                <a href="javascript:void(0)" class="bar-item float-right"><i class="fa fa-search"></i></a>
            </div>

            <p>Navigation bar with input:</p>
            <div class="navbar border">
                <nav class="flex flex-row">
                    <a href="javascript:void(0)" class="bar-item gray-20 mobile">Home</a>
                    <a href="javascript:void(0)" class="bar-item mobile">Link 1</a>
                    <a href="javascript:void(0)" class="bar-item mobile">Link 2</a>
                </nav>
                <div class="bar-item mobile bar-search">
                    <label for="bar-search-1" class="sr-only">Search...</label>
                    <input type="text" class="white" id="bar-search-1" name="bar-search-1" placeholder="Search...">
                    <a href="javascript:void(0)" class="button primary"><i class="fa fa-search"></i></a>
                </div>
            </div>

            <p>Navigation bar with dropdown:</p>
            <div class="bar flex">
                <a href="javascript:void(0)" class="bar-item mobile">Home</a>
                <a href="javascript:void(0)" class="bar-item mobile">Link 1</a>
                <div class="dropdown center relative mobile"
                     x-data="dropdownData"
                     @click.outside="hideDropdown"
                >
                    <button @click="toggleDropdown" class="fs-16 normal transparent margin-top-0">Dropdown <i
                            class="fa fa-caret-down"></i>
                    </button>
                    <div x-show="openDropdown" class="dropdown-content bar-block card card-4">
                        <a class="bar-item" href="javascript:void(0)">Link 1</a>
                        <a class="bar-item" href="javascript:void(0)">Link 2</a>
                        <a class="bar-item" href="javascript:void(0)">Link 3</a>
                    </div>
                </div>
                <a href="javascript:void(0)" class="bar-item float-right mobile"><i
                        class="fa fa-search"></i></a>
            </div>
            <div class="hide-mobile">
                <p>Customized bars:</p>

                <div class="bar">
                    <a class="bar-item mobile green no-underline third" href="javascript:void(0)">Home</a>
                    <a class="bar-item mobile third" href="javascript:void(0)">Link 1</a>
                    <a class="bar-item mobile third" href="javascript:void(0)">Link 2</a>
                </div>

            </div>


            <hr>


            <h3>5. Box</h3>
            <p>The <a href="#">box</a> class is the most important of the
                Clean.CSS classes. It provides equality like:</p>
            <ul>
                <li>Common margins</li>
                <li>Common paddings</li>
                <li>Common vertical alignments</li>
                <li>Common horizontal alignments</li>
                <li>Common fonts</li>
                <li>Common colors</li>
            </ul>

            <p>The box class is typically used with HTML container elements, like:</p>
            <p>&lt;div&gt;, &lt;header&gt;, &lt;footer&gt;, &lt;article&gt;, &lt;section&gt;, &lt;blockquote&gt;, &lt;form&gt;,
                and
                more.</p>

            <article class="section">
                <div class="box gray-60 round-top">
                    <h4 class="text-white">This is a Header</h4>
                </div>
                <div class="box gray-20 text-gray-80">
                    <p>
                        This article is light grey and the text is brown.
                        This article is light grey and the text is brown.
                        This article is light grey and the text is brown.
                        This article is light grey and the text is brown.
                        This article is light grey and the text is brown.
                    </p>
                </div>
                <div class="box gray-60 round-bottom">
                    <p class="opacity">This is a footer.</p>
                </div>
            </article>

            <p>The <a href="#">box</a>
                class can also display all kinds of notes and quotes:</p>

            <div class="box round border border-default margin-bottom-top-1">
                <p>London is the most populous city in the United Kingdom,
                    with a metropolitan area of over 9 million inhabitants.</p>
            </div>

            <div class="box round gray-20 border border-default margin-bottom-top-1">
                <p>London is the most populous city in the United Kingdom,
                    with a metropolitan area of over 9 million inhabitants.</p>
            </div>

            <div class="box round red-pale leftbar border border-red margin-bottom-top-1">
                <p>London is the most populous city in the United Kingdom,
                    with a metropolitan area of over 9 million inhabitants.</p>
            </div>

            <div class="box round green-pale bottombar border-green border margin-top-bottom-1">
                <p>London is the most populous city in the United Kingdom,
                    with a metropolitan area of over 9 million inhabitants.</p>
            </div>

            <div class="box round leftbar border border-default orange-pale margin-top-bottom-1">
                <p><i class="fs-24 serif">"Make it as simple as possible, but not simpler."</i></p>
                <p>Albert Einstein</p>
            </div>

            <h4>Example:</h4>
            <pre><code class="language-html">&lt;article class=&quot;section&quot;&gt;
    &lt;div class=&quot;box gray-60 round-top&quot;&gt;
        &lt;h4 class=&quot;text-white&quot;&gt;This is a Header&lt;/h4&gt;
    &lt;/div&gt;
    &lt;div class=&quot;box gray-20 text-gray-80&quot;&gt;
        &lt;p&gt;
            This article is light grey and the text is brown.
            This article is light grey and the text is brown.
            This article is light grey and the text is brown.
            This article is light grey and the text is brown.
            This article is light grey and the text is brown.
        &lt;/p&gt;
    &lt;/div&gt;
    &lt;div class=&quot;box gray-60 round-bottom&quot;&gt;
        &lt;p class=&quot;opacity&quot;&gt;This is a footer.&lt;/p&gt;
    &lt;/div&gt;
&lt;/article&gt;</code></pre>


            <hr>

            <h3>6. Breadcrumb</h3>

            <p>Left-aligned breadcrumb</p>

            <nav class="breadcrumb">
                <ol>
                    <li>
                        <a href="#">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            Home
                        </a>
                    </li>
                    <li>
                        <i class="fa-solid fa-angle-right"></i>
                    </li>
                    <li>About page</li>
                </ol>
            </nav>

            <p class="text-center">Center-aligned breadcrumb</p>

            <nav class="breadcrumb breadcrumb-center">
                <ol>
                    <li>
                        <a href="#">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            Home
                        </a>
                    </li>
                    <li>
                        <i class="fa-solid fa-angle-right"></i>
                    </li>
                    <li>About page</li>
                </ol>
            </nav>

            <h4>Example:</h4>
            <pre><code class="language-html">&lt;p&gt;Left-aligned breadcrumb&lt;/p&gt;

&lt;nav class=&quot;breadcrumb&quot;&gt;
    &lt;ol&gt;
        &lt;li&gt;
            &lt;a href=&quot;#&quot;&gt;
                &lt;i class=&quot;fa fa-home&quot; aria-hidden=&quot;true&quot;&gt;&lt;/i&gt;
                Home
            &lt;/a&gt;
        &lt;/li&gt;
        &lt;li&gt;
            &lt;i class=&quot;fa-solid fa-angle-right&quot;&gt;&lt;/i&gt;
        &lt;/li&gt;
        &lt;li&gt;About page&lt;/li&gt;
    &lt;/ol&gt;
&lt;/nav&gt;

&lt;p&gt;Center-aligned breadcrumb&lt;/p&gt;

&lt;nav class=&quot;breadcrumb breadcrumb-center&quot;&gt;
    &lt;ol class=&quot;breadcrumb-center&quot;&gt;
        &lt;li&gt;
            &lt;a href=&quot;#&quot;&gt;
                &lt;i class=&quot;fa fa-home&quot; aria-hidden=&quot;true&quot;&gt;&lt;/i&gt;
                Home
            &lt;/a&gt;
        &lt;/li&gt;
        &lt;li&gt;
            &lt;i class=&quot;fa-solid fa-angle-right&quot;&gt;&lt;/i&gt;
        &lt;/li&gt;
        &lt;li&gt;About page&lt;/li&gt;
    &lt;/ol&gt;
&lt;/nav&gt;</code></pre>


            <hr>


            <h3>7. Button</h3>
            <p>Disputationi dicam vulputate fusce detracto suavitate. Fabulas nisi mnesarchum meliore saperet. Audire et
                mattis option usu morbi.</p>
            <div class="section">
                <button class="primary">Primary</button>
                <button class="secondary">Secondary</button>
                <button class="danger">Danger</button>
                <button class="warning">Danger</button>
                <button class="info">Information</button>
                <button class="success">Success</button>
                <button class="black-button">Button</button>
                <button class="white-button">Button</button>
                <button disabled>Disabled</button>
                <button class="link">Button</button>
            </div>
            <div class="section">
                <button class="alt primary">Cancel</button>
                <button class="alt secondary">Cancel</button>
                <button class="danger alt round-large">Button</button>
                <button class="warning alt round-large">Button</button>
                <button class="info alt round">Button</button>
                <button class="success alt round-xlarge">Button</button>
                <button class="black padding-large hover-red border-black hover-border-red">Button</button>
            </div>

            <p>Circular or square buttons:</p>

            <div class="button-group">
                <button class="button-circle ripple danger">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                </button>

                <button class="button-square ripple info">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                </button>

                <button class="button-circle ripple success">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                </button>

                <button class="button-circle ripple white-button">
                    <i class="fa fa-minus" aria-hidden="true"></i>
                </button>

                <button class="button-circle ripple black-button">
                    <i class="fa fa-pencil" aria-hidden="true"></i>
                </button>
            </div>

            <p>Button bar</p>

            <div class="bar three">
                <button class="bar-item white-button"><i class="fa fa-plus" aria-hidden="true"></i></button>
                <button class="bar-item white-button">Two</button>
                <button class="bar-item white-button">Three</button>
            </div>


            <h4>Example:</h4>
            <pre><code class="language-html">&lt;div class=&quot;section&quot;&gt;
    &lt;button class=&quot;primary&quot;&gt;Primary&lt;/button&gt;
    &lt;button class=&quot;secondary&quot;&gt;Secondary&lt;/button&gt;
    &lt;button class=&quot;danger&quot;&gt;Danger&lt;/button&gt;
    &lt;button class=&quot;warning&quot;&gt;Danger&lt;/button&gt;
    &lt;button class=&quot;info&quot;&gt;Information&lt;/button&gt;
    &lt;button class=&quot;success&quot;&gt;Success&lt;/button&gt;
    &lt;button class=&quot;black-button&quot;&gt;Button&lt;/button&gt;
    &lt;button class=&quot;white-button&quot;&gt;Button&lt;/button&gt;
    &lt;button disabled&gt;Disabled&lt;/button&gt;
&lt;/div&gt;
&lt;div class=&quot;section&quot;&gt;
    &lt;button class=&quot;alt primary&quot;&gt;Cancel&lt;/button&gt;
    &lt;button class=&quot;alt secondary&quot;&gt;Cancel&lt;/button&gt;
    &lt;button class=&quot;danger alt round-large&quot;&gt;Button&lt;/button&gt;
    &lt;button class=&quot;warning alt round-large&quot;&gt;Button&lt;/button&gt;
    &lt;button class=&quot;info alt round&quot;&gt;Button&lt;/button&gt;
    &lt;button class=&quot;success alt round-xlarge&quot;&gt;Button&lt;/button&gt;
    &lt;button class=&quot;black padding-large hover-red border-black hover-border-red&quot;&gt;Button&lt;/button&gt;
&lt;/div&gt;

&lt;p&gt;Circular or square buttons:&lt;/p&gt;

&lt;div class=&quot;button-group&quot;&gt;
    &lt;button class=&quot;button-circle ripple danger&quot;&gt;
        &lt;i class=&quot;fa fa-trash&quot; aria-hidden=&quot;true&quot;&gt;&lt;/i&gt;
    &lt;/button&gt;

    &lt;button class=&quot;button-square ripple info&quot;&gt;
        &lt;i class=&quot;fa fa-plus&quot; aria-hidden=&quot;true&quot;&gt;&lt;/i&gt;
    &lt;/button&gt;

    &lt;button class=&quot;button-circle ripple success&quot;&gt;
        &lt;i class=&quot;fa fa-plus&quot; aria-hidden=&quot;true&quot;&gt;&lt;/i&gt;
    &lt;/button&gt;

    &lt;button class=&quot;button-circle ripple white-button&quot;&gt;
        &lt;i class=&quot;fa fa-minus&quot; aria-hidden=&quot;true&quot;&gt;&lt;/i&gt;
    &lt;/button&gt;

    &lt;button class=&quot;button-circle ripple black-button&quot;&gt;
        &lt;i class=&quot;fa fa-pencil&quot; aria-hidden=&quot;true&quot;&gt;&lt;/i&gt;
    &lt;/button&gt;
&lt;/div&gt;

&lt;p&gt;Button bar&lt;/p&gt;

&lt;div class=&quot;bar three&quot;&gt;
    &lt;button class=&quot;bar-item white-button&quot;&gt;&lt;i class=&quot;fa fa-plus&quot; aria-hidden=&quot;true&quot;&gt;&lt;/i&gt;&lt;/button&gt;
    &lt;button class=&quot;bar-item white-button&quot;&gt;Two&lt;/button&gt;
    &lt;button class=&quot;bar-item white-button&quot;&gt;Three&lt;/button&gt;
&lt;/div&gt;</code></pre>


            <hr>


            <h3>8. Card</h3>
            <p>The <a href="#">card</a>
                classes are suitable for both images and notes:</p>

            <div class="card card-4 content-600">
                <div class="box round-top primary">
                    <h2 class="text-white">A Car</h2>
                </div>
                <div class="box round-bottom">
                    <p>
                        A car is a wheeled, self-powered motor vehicle used for transportation.
                        Most definitions of the term specify that cars are designed to run primarily on roads,
                        to have seating for one to eight people, and to typically have four wheels.
                        <br><br>(Wikipedia)
                    </p>
                    <img src="{{ url('/images/img_snowtops.jpg') }}" alt="Car">
                    <p>French Alps</p>
                </div>
            </div>

            <br>

            <div class="row-padding">
                <div class="half">
                    <div class="card">
                        <div class="box primary round-top">
                            <h3 class="text-white">Movies 2014</h3>
                        </div>
                        <div class="box">
                            <ul>
                                <li>
                                    <h4>Frozen</h4>
                                    <p>The response to the animations was ridiculous</p>
                                </li>
                                <li>
                                    <h4>The Fault in Our Stars</h4>
                                    <p>Touching, gripping and genuinely well-made</p>
                                </li>
                                <li>
                                    <h4>The Avengers</h4>
                                    <p>A huge success for Marvel and Disney</p>
                                </li>
                            </ul>
                        </div>

                        <div class="box text-white primary fs-24 round-bottom">&laquo;<span
                                class="text-white float-right">&raquo;</span></div>
                    </div>
                </div>

                <div class="half">
                    <div class="card">
                        <div class="box accent-dark round-top">
                            <h3 class="text-black">Movies 2014</h3>
                        </div>
                        <div class="box">
                            <ul>
                                <li>
                                    <h4>Frozen</h4>
                                    <p>The response to the animations was ridiculous</p>
                                </li>
                                <li>
                                    <h4>The Fault in Our Stars</h4>
                                    <p>Touching, gripping and genuinely well-made</p>
                                </li>
                                <li>
                                    <h4>The Avengers</h4>
                                    <p>A huge success for Marvel and Disney</p>
                                </li>
                            </ul>
                        </div>
                        <div class="box accent-dark fs-24 round-bottom pointer">&laquo;<span
                                class="float-right">&raquo;</span></div>
                    </div>
                </div>
            </div>

            <div>
                <h4>Example:</h4>
                <pre><code class="language-html">&lt;div class=&quot;card card-4 content-600&quot;&gt;
    &lt;div class=&quot;box round-top primary&quot;&gt;
        &lt;h2 class=&quot;text-white&quot;&gt;A Car&lt;/h2&gt;
    &lt;/div&gt;
    &lt;div class=&quot;box round-bottom&quot;&gt;
        &lt;p&gt;
            A car is a wheeled, self-powered motor vehicle used for transportation.
            Most definitions of the term specify that cars are designed to run primarily on roads,
            to have seating for one to eight people, and to typically have four wheels.
            &lt;br&gt;&lt;br&gt;(Wikipedia)
        &lt;/p&gt;
        &lt;img src=&quot;{{ url('/images/img_snowtops.jpg') }}&quot; alt=&quot;Car&quot;&gt;
        &lt;p&gt;French Alps&lt;/p&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
            </div>


            <hr>


            <h3>9. Dropdown</h3>
            <p>The <a href="#"><strong>dropdown</strong></a>
                classes provide dropdowns:</p>
            <div class="row">
                <div class="col s6">
                    <div x-data="dropdownData" class="dropdown" @click.outside="hideDropdown">
                        <button @mouseover="toggleDropdown" class="black-button">
                            Hover Me! <i class="fa fa-caret-down"></i>
                        </button>
                        <div x-show="openDropdown" class="dropdown-content bar-block border card card-4">
                            <a class="bar-item" href="javascript:void(0)">Link 1</a>
                            <a class="bar-item" href="javascript:void(0)">Link 2</a>
                            <a class="bar-item" href="javascript:void(0)">Link 3</a>
                        </div>
                    </div>
                </div>
                <div class="col s6">
                    <div x-data="dropdownData" class="dropdown" @click.outside="hideDropdown">
                        <button @click="toggleDropdown" class="black-button">
                            Click Me! <i class="fa fa-caret-down"></i>
                        </button>
                        <div x-show="openDropdown" class="dropdown-content bar-block card card-4">
                            <a class="bar-item" href="javascript:void(0)">Link 1</a>
                            <a class="bar-item" href="javascript:void(0)">Link 2</a>
                            <a class="bar-item" href="javascript:void(0)">Link 3</a>
                        </div>
                    </div>
                </div>
            </div>

            <h4>Example:</h4>
            <pre><code class="language-html">&lt;div class=&quot;row&quot;&gt;
    &lt;div class=&quot;col s6&quot;&gt;
        &lt;div x-data=&quot;dropdownData&quot; class=&quot;dropdown&quot; @click.outside=&quot;hideDropdown&quot;&gt;
            &lt;button @mouseover=&quot;toggleDropdown&quot; class=&quot;black-button&quot;&gt;
                Hover Me! &lt;i class=&quot;fa fa-caret-down&quot;&gt;&lt;/i&gt;
            &lt;/button&gt;
            &lt;div x-show=&quot;openDropdown&quot; class=&quot;dropdown-content bar-block border&quot;&gt;
                &lt;a class=&quot;bar-item&quot; href=&quot;javascript:void(0)&quot;&gt;Link 1&lt;/a&gt;
                &lt;a class=&quot;bar-item&quot; href=&quot;javascript:void(0)&quot;&gt;Link 2&lt;/a&gt;
                &lt;a class=&quot;bar-item&quot; href=&quot;javascript:void(0)&quot;&gt;Link 3&lt;/a&gt;
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    &lt;div class=&quot;col s6&quot;&gt;
        &lt;div x-data=&quot;dropdownData&quot; class=&quot;dropdown&quot; @click.outside=&quot;hideDropdown&quot;&gt;
            &lt;button @click=&quot;toggleDropdown&quot; class=&quot;black-button&quot;&gt;
                Click Me! &lt;i class=&quot;fa fa-caret-down&quot;&gt;&lt;/i&gt;
            &lt;/button&gt;
            &lt;div x-show=&quot;openDropdown&quot; class=&quot;dropdown-content bar-block card card-4&quot;&gt;
                &lt;a class=&quot;bar-item&quot; href=&quot;javascript:void(0)&quot;&gt;Link 1&lt;/a&gt;
                &lt;a class=&quot;bar-item&quot; href=&quot;javascript:void(0)&quot;&gt;Link 2&lt;/a&gt;
                &lt;a class=&quot;bar-item&quot; href=&quot;javascript:void(0)&quot;&gt;Link 3&lt;/a&gt;
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>


            <hr>


            <h3>10. Filter</h3>
            <p>Use <a href="#">Clean.CSS Filters</a> to search for a specific element inside a list, table, dropdown,
                etc.:</p>

            <div x-data="filterData" x-init="dataType = 'table'; sourceId = 'filter-table';">
                <label for="name-search" class="sr-only">Search for names</label>
                <input type="text" name="name-search" id="name-search" placeholder="Search for names..." x-model="filterTerm"
                       @keyup="filter()">

                <table id="filter-table">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Country</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Alfreds Futterkiste</td>
                        <td>Germany</td>
                    </tr>
                    <tr>
                        <td>Berglunds snabbkop</td>
                        <td>Sweden</td>
                    </tr>
                    <tr>
                        <td>Island Trading</td>
                        <td>UK</td>
                    </tr>
                    <tr>
                        <td>Koniglich Essen</td>
                        <td>Germany</td>
                    </tr>
                    <tr>
                        <td>Laughing Bacchus Winecellars</td>
                        <td>Canada</td>
                    </tr>
                    <tr>
                        <td>Magazzini Alimentari Riuniti</td>
                        <td>Italy</td>
                    </tr>
                    <tr>
                        <td>North/South</td>
                        <td>UK</td>
                    </tr>
                    <tr>
                        <td>Paris specialites</td>
                        <td>France</td>
                    </tr>
                    </tbody>
                </table>
            </div>


            <hr>


            <h3>11. Form</h3>
            <p>Happiness can be found even in the darkest of times if only one remembers to turn on the light.</p>

            <div class="row-padding">
                <div class="third">
                    <label for="one">One</label>
                    <input type="text" placeholder="One" id="one" name="one">
                </div>
                <div class="third">
                    <label for="two">Two</label>
                    <input type="text" placeholder="Two" id="two" name="two">
                </div>
                <div class="third">
                    <label for="three">Three</label>
                    <input type="text" placeholder="Three" id="three" name="three">
                </div>
            </div>

            <div class="row-padding">
                <div class="half">
                    <label for="firstname">First name</label>
                    <input type="text" name="firstname" id="firstname" placeholder="First name">
                </div>
                <div class="half">
                    <label for="familyname">Family name</label>
                    <input type="text" name="familyname" id="familyname" placeholder="Family name">
                </div>
            </div>


            <div class="row-padding">
                <div class="half">
                    <div class="margin-bottom-1">
                        <label for="fruit">Fruits<span class="text-red">*</span></label>
                        <select id="fruit" name="fruit"
                                class="@error('fruit') is-invalid @enderror">
                            <option value="0">Select fruit</option>
                            @foreach($fruits as $fruit)
                                <option
                                    {{ old('fruit') == $fruit ? 'selected' : ''  }} value="{{ $fruit }}">{{ $fruit }}</option>
                            @endforeach
                        </select>
                        @error('fruit')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="margin-bottom-1">
                        <label for="logo"
                               class="@error('logo') is-invalid @enderror">Select logo
                            <span class="text-danger">*</span></label>
                        <input type="file" class="form-control-file" id="logo"
                               name="logo">
                        @error('logo')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="margin-bottom-1">
                        <label for="gallery"
                               class="@error('gallery') is-invalid @enderror">Upload images for the gallery</label>
                        <input type="file" class="form-control-file" id="gallery"
                               name="gallery[]" multiple>

                        @error('gallery')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>


            <div class="row-padding">
                <div class="half">
                    <div class="card card-4 margin-top-1-5">
                        <div class="box primary round-top">
                            <h3 class="text-white">Input Form</h3>
                        </div>
                        <form class="box padding-bottom-1-5">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" disabled>

                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" required>

                            <label for="message">Message</label>
                            <textarea rows="5" name="message" id="message"></textarea>

                            <label>What do you need from the grocery's?</label>

                            <label for="milk" class="margin-top-bottom-0">
                                <input id="milk" type="checkbox" checked="checked">Milk
                            </label>

                            <label for="sugar" class="margin-top-bottom-0">
                                <input id="sugar" type="checkbox">Sugar
                            </label>

                            <label for="lemon" class="margin-top-bottom-0">
                                <input id="lemon" type="checkbox" disabled>Lemon (Disabled)
                            </label>

                        </form>
                    </div>
                </div>

                <div class="half">
                    <div class="card card-4 margin-top-1-5">
                        <div class="box red round-top">
                            <h3 class="text-white">Input Form</h3>
                        </div>
                        <form class="box padding-bottom-1-5">
                            <label for="your-name">Name</label>
                            <input type="text" name="your_name" id="your-name" required>

                            <label for="your-email">Email </label>
                            <input type="email" name="your_email" id="your-email" required>

                            <label for="your-message">Message </label>
                            <textarea name="your_message" id="your-message" rows="5"></textarea>

                            <label>Sex</label>

                            <label for="male" class="margin-top-bottom-0">
                                <input id="male" type="radio" name="gender" value="male" checked>Male
                            </label>
                            <label for="female" class="margin-top-bottom-0">
                                <input id="female" type="radio" name="gender" value="female" checked>Female
                            </label>
                            <label for="dont-know" class="margin-top-bottom-0">
                                <input id="dont-know" type="radio" name="gender" value="" disabled>Don't know (Disabled)
                            </label>

                        </form>
                    </div>
                </div>
            </div>


            <hr>


            <h3>12. Heading</h3>

            <h1> Heading 1 </h1>
            <h2> Heading 2 </h2>
            <h3> Heading 3 </h3>
            <h4> Heading 4 </h4>
            <h5> Heading 5 </h5>
            <h6> Heading 6 </h6>


            <hr>


            <h3>13. Image</h3>
            <p>Styling <a href="#">images</a> in Clean.CSS is easy:</p>

            <div class="row-padding">
                <div class="col m3 s4">
                    <img src="{{ url('/images/img_lights.jpg') }}" class="round"
                         alt="Northern Lights">
                </div>
                <div class="col m3 s4">
                    <img src="{{ url('/images/img_forest.jpg') }}" class="circle" alt="Forest">
                </div>
                <div class="col m3 s4">
                    <img src="{{ url('/images/img_mountains.jpg') }}" class="hover-opacity border"
                         alt="Mountains">
                </div>
                <div class="col m3 hide-mobile">
                    <div class="relative">
                        <img src="{{ url('/images/img_nature.jpg') }}" alt="Nature"
                             class="card card-4">
                        <div class="bottomleft text-white black-transparent box padding-0-5">Nature
                        </div>
                    </div>
                </div>

            </div>
            <div style="clear:both;margin-bottom:28px;"></div>


            <hr>


            <h3>14. Lightbox (deprecated)</h3>
            <p>Combine <a href="#">Modals</a> and <a href="#">Slideshows</a> to create a
                lightbox
                (modal image gallery):</p>
            <div x-data="lightboxData">
                <div x-show="openLighbox" class="gallery-modal black" :class="{'show': openLighbox }">
                <span class="text-white white-transparent fs-24 hover-text-grey-20 padding-0-5 topright pointer"
                      title="Close Lightbox" @click="closeLightbox()">&times;</span>
                    <div class="modal-content content-1024">

                        <div class="content-960 margin-left-right-auto">
                            <img class="lightbox-item" src="{{ url('/images/img_nature_wide.jpg') }}"
                                 alt="Nature">
                            <img class="lightbox-item" src="{{ url('/images/img_snow_wide.jpg') }}"
                                 alt="Snow">
                            <img class="lightbox-item" src="{{ url('/images/img_mountains_wide.jpg') }}"
                                 alt="Mountains">
                            <div class="row black center">
                                <div class="box relative">
                                    <p id="lightbox-caption-id" class="text-center"></p>
                                    <span class="middle hover-text-accent padding-0-5 large pointer" style="left:2%"
                                          @click="stepLightbox(-1)" title="Previous image">&#10094;</span>
                                    <span class="middle hover-text-accent padding-0-5 large pointer" style="left:98%"
                                          @click="stepLightbox(1)" title="Next image">&#10095;</span>
                                </div>

                                <div class="col s4">
                                    <img class="lightbox-dots opacity hover-opacity-off pointer"
                                         src="{{ url('/images/img_nature_wide.jpg') }}"
                                         @click="currentLightbox(1)" alt="Nature and sunrise">
                                </div>
                                <div class="col s4">
                                    <img class="lightbox-dots opacity hover-opacity-off pointer"
                                         src="{{ url('/images/img_snow_wide.jpg') }}"
                                         @click="currentLightbox(2)" alt="French Alps">
                                </div>
                                <div class="col s4">
                                    <img class="lightbox-dots opacity hover-opacity-off pointer"
                                         src="{{ url('/images/img_mountains_wide.jpg') }}"
                                         @click="currentLightbox(3)" alt="Mountains and fjords">
                                </div>
                            </div> <!-- End row -->
                        </div> <!-- End content-960 -->

                    </div> <!-- End modal content -->
                </div> <!-- End modal -->

                <div class="row-padding">
                    <div class="col s4">
                        <img src="{{ url('/images/img_nature_wide.jpg') }}"
                             @click="openLightbox();currentLightbox(1)" class="hover-shadow pointer" alt="Nature">
                    </div>
                    <div class="col s4">
                        <img src="{{ url('/images/img_snow_wide.jpg') }}"
                             @click="openLightbox();currentLightbox(2)" class="hover-shadow pointer" alt="Snow">
                    </div>
                    <div class="col s4">
                        <img src="{{ url('/images/img_mountains_wide.jpg') }}"
                             @click="openLightbox();currentLightbox(3)" class="hover-shadow pointer" alt="Mountains">
                    </div>
                </div>
            </div>


            <hr>


            <h3>15. List</h3>

            <h4> Ordered </h4>
            <ol>
                <li> First</li>
                <li> Second</li>
                <li> Third</li>
            </ol>

            <h4> Unordered </h4>
            <ul>
                <li> Item C</li>
                <li> Item A</li>
                <li> Item B</li>
            </ul>

            <h4> Nested </h4>
            <ol>
                <li>
                    First
                    <ul>
                        <li> Item A</li>
                        <li> Item B</li>
                    </ul>
                </li>
                <li> Second</li>
                <li> Third</li>
            </ol>

            <h4> Definition Lists </h4>
            <dl>
                <dt> Term</dt>
                <dd> Definition 1</dd>
                <dd> Definition 2</dd>
                <dd> Definition 3</dd>
            </dl>


            <hr>


            <h3>16. Modal</h3>
            <p>The <a href="#">modal</a>
                class provides modal dialog in pure HTML:</p>

            <div x-data="modalData">
                <button @click="openModal()"
                        class="black-button">Click to Open Modal
                </button>

                <div x-show="modal" x-cloak class="modal" :class="{'show': modal}">
                    <div class="modal-content content-600 card card-4 animate-top relative">
                        <div class="box primary round-top">
                            <button @click="closeModal()"
                                    class="close-button fs-18 primary topright round-top-right text-white">&times;
                            </button>
                            <h3 class="text-white">Header</h3>
                        </div>
                        <div class="box white">
                            <p>Some text. Some text. Some text.</p>
                            <p>Some text. Some text. Some text.</p>
                        </div>
                        <div class="box primary round-bottom text-gray-10">
                            <p>Footer</p>
                        </div>
                    </div>
                </div>
            </div>


            <p>Modal Image:</p>

            <div x-data="modalData">
                <img class="hover-opacity thumbnail-third pointer"
                     role="button"
                     src="{{ url('/images/img_nature.jpg') }}"
                     alt="Nature"
                     @click="openModal()">

                <div x-show="modal" x-cloak class="modal" :class="{'show': modal}" @click="closeModal()">
                    <span class="close-button gray-20 fs-18 topright">&times;</span>
                    <div class="modal-content content-960 card card-4 animate-zoom">
                        <img src="{{ url('/images/img_nature_wide.jpg') }}" alt="Nature">
                    </div>
                </div>
            </div>


            <hr>


            <h3>17. Pagination</h3>
            <p>Clean.CSS provides simple ways for <a href="#">page pagination</a>.</p>

            <div class="bar pagination margin-top-bottom-1">
                <a class="bar-item button transparent" href="javascript:void(0)">&laquo;</a>
                <a class="bar-item button active" href="javascript:void(0)">1</a>
                <a class="bar-item button transparent" href="javascript:void(0)">2</a>
                <a class="bar-item button transparent" href="javascript:void(0)">3</a>
                <a class="bar-item button transparent" href="javascript:void(0)">4</a>
                <a class="bar-item button transparent" href="javascript:void(0)">5</a>
                <a class="bar-item button transparent" href="javascript:void(0)">&raquo;</a>
            </div>

            <div class="bar border round margin-top-bottom-1">
                <a href="javascript:void(0)" class="button link-button">&#10094; Previous</a>
                <a href="javascript:void(0)" class="button float-right link-button">Next &#10095;</a>
            </div>


            <hr>


            <h3>18. Person</h3>
            <p>We’ve all got both light and dark inside us. What matters is the part we choose to act on. That’s who we
                really are.</p>

            <div class="card relative padding-1 hover-gray-20 ">
                <img src="{{ url('/images/img_avatar2.png') }}"
                     class="float-left circle margin-right-1 profile" alt="Mike">
                <strong class="fs-24">Mike</strong><br>
                <i>Web Designer</i>

                <p>It does not do to dwell on dreams and forget to live.</p>

                <button onclick="this.parentElement.style.display='none'"
                        class="close-button white fs-18 absolute topright margin-right-0-5">
                    <i class="fa fa-times"></i>
                </button>
            </div>


            <ul class="card card-4">

                <li class="hover-gray-20 relative">
                    <img src="{{ url('/images/img_avatar2.png') }}"
                         class="float-left circle margin-right-1 profile" alt="Mike">
                    <strong class="fs-24">Mike</strong><br>
                    <i>Web Designer</i>
                </li>

                <li class="hover-gray-20 relative">
                    <img src="{{ url('/images/img_avatar5.png') }}"
                         class="float-left circle margin-right-1 profile" alt="Jill">
                    <strong class="fs-24">Jill</strong><br>
                    <i>Support</i>
                </li>

                <li class="hover-gray-20 relative">
                    <img src="{{ url('/images/img_avatar6.png') }}"
                         class="float-left circle margin-right-1 profile" alt="Jane">
                    <strong class="fs-24">Jane</strong><br>
                    <i>Accountant</i>
                </li>

                <li class="hover-gray-20 relative">
                    <img src="{{ url('/images/img_avatar3.png') }}"
                         class="float-left circle margin-right-1 profile" alt="Jack">
                    <strong class="fs-24">Jack</strong><br>
                    <i>Advisor</i>
                </li>
            </ul>


            <hr>


            <h3>19. Progress Bar</h3>
            <p>Utamur liber parturient eget elaboraret ridiculus nullam facilisis. Enim errem pericula consectetur
                evertitur erat wisi praesent.</p>

            <div class="gray-20">
                <div class="box green center" style="width:25%">25%</div>
            </div>
            <br>

            <div class="gray-20">
                <div class="box red center" style="width:50%">50%</div>
            </div>
            <br>

            <div x-data="progressBarData" x-init="width = 2; speed = 25;">
                <div class="gray-20">
                    <div class="box green" style="width:5%; height: 24px" :style="{ width: (width + '%') }"
                         x-text="label">0
                    </div>
                </div>
                <br>

                <button class="black-button" @click="triggerMove()">
                    Click Me
                </button>
            </div>


            <hr>


            <h3>20. Slideshow (deprecated)</h3>
            <p>Clean.CSS provide <a href="#">slideshows</a> for cycling through images or
                other
                content:</p>

            <div x-data="sliderData" x-init="slideItemClass = 'slide-item'; slideDotsClass = 'slide-dots';"
                 class="content-960 margin-left-right-auto relative">
                <div class="relative slide-item">
                    <img src="{{ url('/images/img_nature_wide.jpg') }}" alt="Beautiful Nature">
                    <div class="topleft padding-1 text-white black-transparent fs-14">
                        1 / 3
                    </div>
                    <div class="topright text-white black-transparent padding-1 hide-mobile">
                        Beautiful Nature
                    </div>
                </div>
                <div class="relative slide-item">
                    <img src="{{ url('/images/img_snow_wide.jpg') }}" alt="French Alps">
                    <div class="topleft text-white black-transparent padding-1 fs-14">
                        2 / 3
                    </div>
                    <div class="topright text-white black-transparent padding-1 hide-mobile">
                        French Alps
                    </div>
                </div>
                <div class="relative slide-item">
                    <img src="{{ url('/images/img_mountains_wide.jpg') }}" alt="Mountains">
                    <div class="topleft text-white black-transparent padding-1 fs-14">
                        3 / 3
                    </div>
                    <div class="topright text-white black-transparent padding-1 hide-mobile">
                        Mountains
                    </div>
                </div>
                <div class="slider-nav center section fs-18 text-white bottomleft">
                    <div class="float-left hover-text-accent padding-0-5 large pointer" @click="switchSlide(-1)">
                        &#10094;
                    </div>
                    <div class="float-right hover-text-accent padding-0-5 large pointer" @click="switchSlide(1)">
                        &#10095;
                    </div>
                    <div class="margin-top-1 text-center">
                        <span class="slide-dots border hover-white" @click="currentSlide(1)"></span>
                        <span class="slide-dots border hover-white" @click="currentSlide(2)"></span>
                        <span class="slide-dots border hover-white" @click="currentSlide(3)"></span>
                    </div>

                </div>
            </div>


            <hr>


            <h3>21. Tab</h3>
            <p><a href="#">Tabs</a> are perfect for single page web applications, or for
                web
                pages capable of displaying different subjects.</p>
            <div x-data="tabsData" class="border round">
                <div class="bar">
                    <a href="javascript:void(0)" class="bar-item tab-switcher"
                       @click="switchTab('London')" :class="{'red': tabId === 'London'}">London</a>
                    <a href="javascript:void(0)" class="bar-item tab-switcher"
                       @click="switchTab('Paris')" :class="{'red': tabId === 'Paris'}">Paris</a>
                    <a href="javascript:void(0)" class="bar-item tab-switcher"
                       @click="switchTab('Tokyo')" :class="{'red': tabId === 'Tokyo'}">Tokyo</a>
                </div>

                <div id="London" class="box tabs animate-opacity red">
                    <h2 class="text-white">London</h2>
                    <p>London is the capital of England.</p>
                    <p>It is the most populous city in the United Kingdom,
                        with a metropolitan area of over 9 million inhabitants.</p>
                </div>

                <div id="Paris" class="box tabs animate-opacity red">
                    <h2 class="text-white">Paris</h2>
                    <p>Paris is the capital of France.</p>
                    <p>The Paris area is one of the largest population centers in Europe,
                        with more than 12 million inhabitants.</p>
                </div>

                <div id="Tokyo" class="box tabs animate-opacity red">
                    <h2 class="text-white">Tokyo</h2>
                    <p>Tokyo is the capital of Japan.</p>
                    <p>It is the center of the Greater Tokyo Area,
                        and the most populous metropolitan area in the world.</p>
                </div>
            </div>

            <br>

            <p>Tabbed Image Gallery (Click on one of the pictures) (deprecated):</p>

            <div x-data="tabbedImagesData">
                <div class="row-padding">
                    <div class="col s3 box">
                        <a href="javascript:void(0)" class="hover-opacity tabbed-image-gallery-button"
                           @click="openTabbedImage('Nature');">
                            <img src="{{ url('/images/img_nature.jpg') }}" alt="Nature">
                        </a>
                    </div>
                    <div class="col s3 box">
                        <a href="javascript:void(0)" class="hover-opacity tabbed-image-gallery-button"
                           @click="openTabbedImage('Snow');">
                            <img src="{{ url('/images/img_snowtops.jpg') }}" alt="Fjords">
                        </a>
                    </div>
                    <div class="col s3 box">
                        <a href="javascript:void(0)" class="hover-opacity tabbed-image-gallery-button"
                           @click="openTabbedImage('Mountains');">
                            <img src="{{ url('/images/img_mountains.jpg') }}" alt="Mountains">
                        </a>
                    </div>
                    <div class="col s3 box">
                        <a href="javascript:void(0)" class="hover-opacity tabbed-image-gallery-button"
                           @click="openTabbedImage('Lights');">
                            <img src="{{ url('/images/img_lights.jpg') }}" alt="Lights">
                        </a>
                    </div>
                </div>

                <br>

                <div id="Nature" class="picture relative tabbed-image-gallery-item">
                    <img src="{{ url('/images/img_nature_wide.jpg') }}" alt="Nature">
                    <span @click="hide(event)"
                          class="topright close-button fs-18 transparent text-white">&times;</span>
                    <div class="bottomleft box padding-0-5 text-white black-transparent">Nature</div>
                </div>

                <div id="Snow" class="picture relative tabbed-image-gallery-item">
                    <img src="{{ url('/images/img_snow_wide.jpg') }}" alt="Snow">
                    <span @click="hide(event)"
                          class="topright close-button fs-18 transparent text-white">&times;</span>
                    <div class="bottomleft box padding-0-5 text-white black-transparent">Snow</div>
                </div>

                <div id="Mountains" class="picture relative tabbed-image-gallery-item">
                    <img src="{{ url('/images/img_mountains_wide.jpg') }}" alt="Mountains">
                    <span @click="hide(event)"
                          class="topright close-button fs-18 transparent">&times;</span>
                    <div class="bottomleft box padding-0-5 text-white black-transparent">Mountains</div>
                </div>

                <div id="Lights" class="picture relative tabbed-image-gallery-item">
                    <img src="{{ url('/images/img_lights_wide.jpg') }}" alt="Lights">
                    <span @click="hide(event)"
                          class="topright close-button fs-18 transparent text-white">&times;</span>
                    <div class="bottomleft box padding-0-5 text-white black-transparent">Northern Lights</div>
                    <div class="bottomleft box padding-0-5 text-white black-transparent">Northern Lights</div>
                </div>
            </div>


            <hr>


            <h3>22. Table</h3>
            <p>No need to add any class. Aeque tempus vulputate voluptatibus iusto nobis. Consequat mediocrem mollis
                ornatus conubia class.</p>

            <table>
                <thead>
                <tr>
                    <th> ID</th>
                    <th> Column A</th>
                    <th> Column B</th>
                    <th> Column C</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td> 0</td>
                    <td> Apple</td>
                    <td> Pear</td>
                    <td> Mango</td>
                </tr>
                <tr>
                    <td> 1</td>
                    <td> Banana</td>
                    <td> Kiwi</td>
                    <td> Grape</td>
                </tr>
                <tr>
                    <td> 2</td>
                    <td> Orange</td>
                    <td> Lemon</td>
                    <td> Lime</td>
                </tr>
                </tbody>
            </table>


            <hr>


            <h3>23. Tooltip</h3>
            <p>The <strong>tooltip</strong>
                class can display all kinds of tooltips:</p>


            <p class="tooltip">
                Hover over this text!
                <i class="fa fa-question-circle pointer" aria-hidden="true"></i>
                <span class="tooltip-content tooltip-top">Tooltip content</span>
            </p>

            <p class="tooltip">
                Hover over this text!
                <i class="fa fa-question-circle pointer" aria-hidden="true"></i>
                <span class="tooltip-content tooltip-right">Tooltip content</span>
            </p>

            <p class="tooltip">
                Hover over this text!
                <i class="fa fa-question-circle pointer" aria-hidden="true"></i>
                <span class="tooltip-content tooltip-bottom">Tooltip content</span>
            </p>

            <div class="clearfix">
                <p class="tooltip" style="float: right">
                    <i class="fa fa-question-circle pointer" aria-hidden="true"></i>
                    Hover over this text!
                    <span class="tooltip-content tooltip-left">Tooltip content</span>
                </p>
            </div>

            <hr>


            <h3>24. Video</h3>
            <video controls title="Test Video">
                <source src="{{ url('/vids/GNOME-Workspace-Switch.mp4') }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>


            <hr>


            <h2>UTILITIES</h2>


            <h3>1. Animation</h3>
            <p>The <a href="#">animate</a>
                classes provide an easy way to slide and fade in elements:</p>

            <div x-data="animateData">
                <div class="center">
                    <button class="success" @click="animate('top')">Top
                    </button>
                    <button class="success" @click="animate('bottom')">
                        Bottom
                    </button>
                    <button class="success" @click="animate('left')">Left
                    </button>
                    <button class="success" @click="animate('right')">Right
                    </button>
                    <button class="success" @click="animate('fade')">Fade In
                    </button>
                    <button class="success" @click="animate('zoom')">Zoom
                    </button>
                    <button class="success" @click="animate('spin')">Spin
                    </button>
                </div>
                <div class="center">
                    <div x-show="target === 'top'" class="panel animate animate-top">Animation is Fun!</div>
                    <div x-show="target === 'bottom'" class="panel animate animate-bottom">Animation is Fun!</div>
                    <div x-show="target === 'left'" class="panel animate animate-left">Animation is Fun!</div>
                    <div x-show="target === 'right'" class="panel animate animate-right">Animation is Fun!</div>
                    <div x-show="target === 'fade'" class="panel animate animate-opacity">Animation is Fun!</div>
                    <div x-show="target === 'zoom'" class="panel animate animate-zoom">Animation is Fun!</div>
                    <div x-show="target === 'spin'" class="panel animate spin">Animation is Fun!</div>
                    <div x-show="target === 'normal'" class="panel animate ">Animation is Fun!</div>
                </div>
            </div>


            <hr>


            <h3>2. Color</h3>
            <p>Quam mandamus ocurreret sonet urna nihil explicari. Laudem fames intellegebat natoque repudiandae
                consectetur.</p>
            <div class="row">
                <div class="quarter">
                    <div class="box primary center padding-1"><p>&nbsp;</p></div>
                    <div class="box accent center padding-1"><p>&nbsp;</p></div>
                </div>
                <div class="quarter">
                    <div class="box primary-dark center padding-1"><p>&nbsp;</p></div>
                    <div class="box accent-dark center padding-1"><p>&nbsp;</p></div>
                </div>
                <div class="quarter hide-mobile">
                    <div class="box orange text-white center padding-1"><p>&nbsp;</p></div>
                    <div class="box red text-white center padding-1"><p>&nbsp;</p></div>
                </div>
                <div class="quarter hide-mobile">
                    <div class="box green center padding-1"><p>&nbsp;</p></div>
                    <div class="box green-dark center padding-1"><p>&nbsp;</p></div>
                </div>
            </div>


            <hr>


            <h3>3. Display</h3>
            <p>Display HTML elements in specific positions:</p>
            <div class="row-padding">

                <div class="half">
                    <div class="relative green thumbnail">
                        <div class="topleft padding-1">Top Left</div>
                        <div class="topright padding-1">Top Right</div>
                        <div class="bottomleft padding-1">Bottom Left</div>
                        <div class="bottomright padding-1">Bottom Right</div>
                        <div class="left padding-1">Left</div>
                        <div class="right padding-1">Right</div>
                        <div class="middle padding-1">Middle</div>
                        <div class="topmiddle hide-mobile padding-1">Top Middle</div>
                        <div class="bottommiddle hide-mobile padding-1">Bottom Middle</div>
                    </div>
                </div>
                <div class="half">
                    <p class="margin-top-1 hide-tablet hide-desktop">
                    <div class="relative green">
                        <img src="{{ url('/images/img_lights.jpg') }}" alt="Lights" class="thumbnail">
                        <div class="topleft padding-1">Top Left</div>
                        <div class="topright padding-1">Top Right</div>
                        <div class="bottomleft padding-1">Bottom Left</div>
                        <div class="bottomright padding-1">Bottom Right</div>
                        <div class="left padding-1">Left</div>
                        <div class="right padding-1">Right</div>
                        <div class="middle padding-1">Middle</div>
                        <div class="topmiddle hide-mobile padding-1">Top Middle</div>
                        <div class="bottommiddle hide-mobile padding-1">Bottom Middle</div>
                    </div>
                </div>
            </div>


            <hr>


            <h3>4. Effect</h3>
            <p>Add special <strong>effects</strong> to any element:</p>
            <div class="row-padding center">

                <div class="col m3 hide-mobile">
                    <img src="{{ url('/images/img_workshop.jpg') }}" alt="Workshop">
                    <div class="red box">
                        <p>Normal</p>
                    </div>
                </div>

                <div class="col m3 s4 opacity">
                    <img src="{{ url('/images/img_workshop.jpg') }}" alt="Workshop">
                    <div class="red box">
                        <p>Opacity</p>
                    </div>
                </div>

                <div class="col m3 s4 grayscale">
                    <img src="{{ url('/images/img_workshop.jpg') }}" alt="Workshop">
                    <div class="red box">
                        <p>Grayscale</p>
                    </div>
                </div>

                <div class="col m3 s4 sepia">
                    <img src="{{ url('/images/img_workshop.jpg') }}" alt="Workshop">
                    <div class="red box">
                        <p>Sepia</p>
                    </div>
                </div>

            </div>


            <hr>


            <h3>5. Responsive Grid</h3>
            <p>The <a href="#">Responsive Grid</a>
                classes provide responsiveness for all device types: PC, laptop, tablet, and mobile.</p>

            <!-- First row -->
            <div class="row-padding">

                <div class="col m4">
                    <div class="col s6 green center">
                        <p>1/2</p>
                    </div>
                    <div class="col s6 black center text-gray-20">
                        <p>1/2</p>
                    </div>
                </div>

                <div class="col m4">
                    <div class="col s4 green center">
                        <p>1/3</p>
                    </div>
                    <div class="col s4 black center text-gray-20">
                        <p>1/3</p>
                    </div>
                    <div class="col s4 black center text-gray-20">
                        <p>1/3</p>
                    </div>
                </div>

                <div class="col m4">
                    <div class="col s4 black center">
                        <p>1/3</p>
                    </div>
                    <div class="col s8 green center text-gray-20">
                        <p>2/3</p>
                    </div>
                </div>

            </div>

            <!-- Second row -->
            <div class="row-padding">

                <div class="col m4">
                    <div class="col s3 green center">
                        <p>1/4</p>
                    </div>
                    <div class="col s3 black center text-gray-20">
                        <p>1/4</p>
                    </div>
                    <div class="col s3 black center text-gray-20">
                        <p>1/4</p>
                    </div>
                    <div class="col s3 black center text-gray-20">
                        <p>1/4</p>
                    </div>
                </div>

                <div class="col m4">
                    <div class="col s6 green center">
                        <p>1/2</p>
                    </div>
                    <div class="col s3 black center">
                        <p>1/4</p>
                    </div>
                    <div class="col s3 black center text-gray-20">
                        <p>1/4</p>
                    </div>
                </div>

                <div class="col m4">
                    <div class="col s8 green center">
                        <p>2/3</p>
                    </div>
                    <div class="col s4 black center text-gray-20">
                        <p>1/3</p>
                    </div>
                </div>

            </div>

            <!-- Third row -->
            <div class="row-padding">

                <div class="col m4">
                    <div class="col s12 green center text-gray-20">
                        <p>1/1</p>
                    </div>
                </div>

                <div class="col m4">
                    <div class="col s3 black center">
                        <p>1/4</p>
                    </div>
                    <div class="col s3 black center">
                        <p>1/4</p>
                    </div>
                    <div class="col s6 green center">
                        <p>1/2</p>
                    </div>
                </div>

                <div class="col m4">
                    <div class="col s3 black center">
                        <p>1/4</p>
                    </div>
                    <div class="col s6 green center">
                        <p>1/2</p>
                    </div>
                    <div class="col s3 black center">
                        <p>1/4</p>
                    </div>
                </div>

            </div>

            <!-- Fourth row -->
            <div class="row-padding">

                <div class="col m4">
                    <div class="col center black text-gray-20" style="width:50px">
                        <p>50px</p>
                    </div>
                    <div class="rest green center text-gray-20">
                        <p>rest</p>
                    </div>
                </div>

                <div class="col m4">
                    <div class="col s3 black center">
                        <p>1/4</p>
                    </div>
                    <div class="rest green center text-gray-20">
                        <p>rest</p>
                    </div>
                </div>

                <div class="col m4">
                    <div class="col center black text-gray-20 float-left" style="width:100px">
                        <p>100px</p>
                    </div>
                    <div class="col center black text-gray-20 float-right" style="width:45px">
                        <p>45px</p>
                    </div>
                    <div class="rest green center text-gray-20">
                        <p>rest</p>
                    </div>
                </div>

            </div>

            <!-- Grid Layout examples -->
            <div class="row-padding">

                <div class="col m4">

                    <div class="col s6">
                        <div class="col s12 orange" style="width:92%;height:125px;margin-right:10px"></div>
                    </div>

                    <div class="col s6">
                        <div class="col s12 green" style="height:75px;margin-bottom:10px"></div>
                        <div class="col s6 green" style="height:40px;"></div>
                        <div class="col s6 black" style="height:40px"></div>
                    </div>

                </div>

                <div class="col m4">

                    <div class="col s3">
                        <div class="col s12 orange" style="width:85%;height:126px;margin-right:20px"></div>
                    </div>

                    <div class="col s6">
                        <div class="col s12 green" style="height:50px;margin-bottom:10px"></div>
                        <div class="col s6 green" style="height:31px;"></div>
                        <div class="col s6 black" style="height:31px;margin-bottom:10px"></div>

                        <div class="col s4 green" style="height:25px;"></div>
                        <div class="col s4 black" style="height:25px"></div>
                        <div class="col s4 green" style="height:25px"></div>
                    </div>

                    <div class="col s3">
                        <div class="col s12 orange" style="width:85%;height:126px;margin-left:10px"></div>
                    </div>

                </div>

                <div class="col m4">

                    <div class="col s12">
                        <div class="col s12 orange" style="height:36px;margin-bottom:10px"></div>
                    </div>

                    <div class="col s12">
                        <div class="col s12 green" style="height:30px;margin-bottom:10px"></div>
                        <div class="col s8 green" style="height:18px;"></div>
                        <div class="col s4 black" style="height:18px;margin-bottom:10px"></div>

                        <div class="col s3 green" style="height:15px;"></div>
                        <div class="col s3 black" style="height:15px"></div>
                        <div class="col s3 green" style="height:15px"></div>
                        <div class="col s3 black" style="height:15px"></div>
                    </div>

                </div>

            </div>

            <p>Clean.CSS also supports a
                <a href="#">12 column mobile-first fluid grid</a>
                with small, medium, and large classes.</p>

        </div>
    </main>

@endsection

@push('scripts')
    <script>
        /* Initialize image upload drag & drop / click areas */
        jQuery(document).ready(function ($) {
            const fruitSelector = $('#fruit');
            // selects with live search
            fruitSelector.select2();


            $('#logo').clean_dropzone({
                preview: true,
                language: {
                    emptyText: '[Drop File Here or Click To Upload]',
                    dragText: '[Drop File Here]',
                    dropText: '[_t_ File(s)]'
                },
                childTemplate: '<div class="col s6 m6 l6"></div>',
                imageClass: 'img-fluid margin-bottom-1 round',
            });

            $('#gallery').clean_dropzone({
                preview: true,
                accepted: ['jpg', 'jpeg', 'png'],
                dropzoneTemplate: '<div class="clean-dropzone"><div class="clean-dropzone-area"></div><div class="clean-dropzone-message"></div><div class="clean-dropzone-preview mt-0"></div></div>',
                parentTemplate: '<div class="row-padding justify-content-center align-items-center"></div>',
                childTemplate: '<div class="col s6 m6 l6"></div>',
                imageClass: 'img-fluid margin-bottom-1 round',
                noneColorClass: 'alert secondary',
                language: {
                    emptyText: '[Drop Files Here or Click To Upload]',
                    dragText: '[Drop Files Here]',
                    dropText: '[_t_ File(s)]'
                },
            });
        });
    </script>
@endpush

@push('head-extra')
    <script src="{{ url('assets/switcher/jquery.simpleswitch.js') }}"></script>
    <script src="{{ url('assets/tom-select/tom-select-2.2.2.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endpush

@push('scripts')
    <script src="{{ url('/js/prism.js') }}" type="text/javascript"></script>
@endpush
