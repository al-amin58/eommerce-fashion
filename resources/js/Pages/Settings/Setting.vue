<template>
    <Head title="Dashboard" />
    <Layout>
    <section class="app-dashboard">
        <div class="card">
            <div class="card-body border-bottom">
                <div class="card card-statistics">
                    <div class="card-header">
                        <vue-notification-list></vue-notification-list>
                        <h4 class="card-title">Settings</h4>
                    </div>
                    <div class="card-body statistics-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="nav flex-column nav-pills me-3 border text-start" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                    <Link class="nav-link active"
                                          id="v-pills-home-tab"
                                          data-bs-toggle="pill"
                                          data-bs-target="#v-pills-home"
                                          type="button" role="tab"
                                          aria-controls="v-pills-home"
                                          aria-selected="true">Frontend Setting</Link>

                                    <button class="nav-link" id="v-pills-profile-tab"
                                            data-bs-toggle="pill"
                                            data-bs-target="#v-pills-profile"
                                            type="button" role="tab"
                                            aria-controls="v-pills-profile"
                                            aria-selected="false">Profile</button>
                                    <button class="nav-link" id="v-pills-socials-tab"
                                            data-bs-toggle="pill"
                                            data-bs-target="#v-pills-socials"
                                            type="button" role="tab"
                                            aria-controls="v-pills-socials"
                                            aria-selected="false">Social Links</button>

                                    
                                    <button class="nav-link"
                                            id="v-pills-messages-tab"
                                            data-bs-toggle="pill"
                                            data-bs-target="#v-pills-messages"
                                            type="button" role="tab"
                                            aria-controls="v-pills-messages"
                                            aria-selected="false">Apprience</button>


                                    <button class="nav-link"
                                            id="v-pills-smtp-tab"
                                            data-bs-toggle="pill"
                                            data-bs-target="#v-pills-smtp"
                                            type="button" role="tab"
                                            aria-controls="v-pills-smtp"
                                            aria-selected="false">SMTP Setup</button>

                                    <button class="nav-link"
                                            id="v-pills-home_content-tab"
                                            data-bs-toggle="pill"
                                            data-bs-target="#v-pills-home_content"
                                            type="button" role="tab"
                                            aria-controls="v-pills-home_content"
                                            aria-selected="false">Home Content</button>


                                    <button class="nav-link"
                                            id="v-pills-category_setup-tab"
                                            data-bs-toggle="pill"
                                            data-bs-target="#v-pills-category_setup"
                                            type="button" role="tab"
                                            aria-controls="v-pills-category_setup"
                                            aria-selected="false">Category Setup</button>


                                    <!-- <a href="/panel/footer-settings" class="nav-link">Footer Setting</a> -->
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="tab-content" id="v-pills-tabContent">
                                    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                        <div class="card">
                                            <h2>Frontend Setup</h2>
                                            <div class="card-body">
                                                <form class="form form-vertical" @submit.prevent="updateBuisnessSetting()">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control mb-1" type="text" v-model="createForm.name" label="App Name" placeholder="App Name" />
                                                        </div>
                                                        <div class="col-12">
                                                            <textarea class="form-control mb-1" v-model="createForm.app_details" placeholder="e.g Discribe some details about your application..."></textarea>
                                                        </div>


                                                        <div class="col-12 mt-2 d-inline-flex align-item-center">
                                                            <button v-if="!isLoding" type="submit" disabled class="btn btn-primary me-1 waves-effect waves-float waves-light">
                                                                <div class="spinner-border text-white me-1"  role="status"></div>
                                                                <span>Submit</span>
                                                            </button>
                                                            <button v-else class="btn btn-primary me-1 waves-effect waves-float waves-light">
                                                                Submit
                                                            </button>

                                                            <button type="reset" class="btn btn-outline-secondary waves-effect">Reset</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                        <div class="card">
                                            <h2>App Profile</h2>
                                            <div class="card-body">
                                                <form class="form form-vertical" @submit.prevent="updateBuisnessSetting()">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input  type="text" class="form-control mb-1" v-model="createForm.address" label="App Address" placeholder="Address" />
                                                        </div>

                                                        <div class="col-12">
                                                            <input type="email" class="form-control mb-1" v-model="createForm.email" label="App Email" placeholder="example@yourdomain.com" />
                                                        </div>

                                                        <div class="col-12">
                                                            <input type="text" class="form-control mb-1" v-model="createForm.phone" label="App Number" placeholder="+8801*-******" />
                                                        </div>

                                                        <div class="col-12 mt-2 d-inline-flex align-item-center">
                                                            <button v-if="!isLoding" type="submit" disabled class="btn btn-primary me-1 waves-effect waves-float waves-light">
                                                                <div class="spinner-border text-white me-1"  role="status"></div>
                                                                <span>Submit</span>
                                                            </button>
                                                            <button v-else class="btn btn-primary me-1 waves-effect waves-float waves-light">
                                                                Submit
                                                            </button>

                                                            <button type="reset" class="btn btn-outline-secondary waves-effect">Reset</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="v-pills-socials" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                                        <div class="card">
                                            <h2>App Profile</h2>
                                            <div class="card-body">
                                                <form class="form form-vertical" @submit.prevent="updateBuisnessSetting()">
                                                    <div class="row">
                                                        <div class="col-12 mb-1">
                                                            <input type="text" class="form-control" v-model="createForm.facebook_profile" label="Facebook" placeholder="fb.com/me" />
                                                        </div>

                                                        <div class="col-12 mb-1">
                                                            <input type="text" class="form-control" v-model="createForm.google_drive" label="Google Drive" placeholder="drive.google.com/me" />
                                                        </div>

                                                        <div class="col-12 mb-1">
                                                            <input type="text" class="form-control" v-model="createForm.youtube" label="Youtube" placeholder="chanel.youtube.com/my-changel" />
                                                        </div>


                                                        <div class="col-12 mb-1">
                                                            <input type="text" class="form-control" v-model="createForm.linkedin_profile" label="Linkedin" placeholder="linkedin.com/me" />
                                                        </div>


                                                        <div class="col-12 mb-1">
                                                            <input type="text" class="form-control" v-model="createForm.twitter_profile" label="Twitter" placeholder="twitter.com/me" />
                                                        </div>

                                                        <div class="col-12 mb-1">
                                                            <input type="text" class="form-control" v-model="createForm.instagram_profile" label="Instagram" placeholder="instagram.com/me" />
                                                        </div>


                                                        <div class="col-12 mt-2 d-inline-flex align-item-center">

                                                            <button v-if="!isLoding" type="submit" disabled class="btn btn-primary me-1 waves-effect waves-float waves-light">
                                                                <div class="spinner-border text-white me-1"  role="status"></div>
                                                                <span>Submit</span>
                                                            </button>


                                                            <button class="btn btn-primary me-1 waves-effect waves-float waves-light">
                                                                Submit
                                                            </button>
                                                            <button type="reset" class="btn btn-outline-secondary waves-effect">Reset</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>


                                <!--                                      <div class="tab-pane fade" id="v-pills-sms_api" role="tabpanel" aria-labelledby="v-pills-sms_api-tab">
                                          <div class="card">
                                              <h2>SMS API Credentials</h2>
                                              <div class="card-body">
                                                  <form class="form form-vertical" @submit.prevent="updateBuisnessSetting()">
                                                      <div class="row">
                                                          <div class="col-md-6">
                                                              <div class="row">
                                                                  <div class="col-12">
                                                                      <input type="text" v-model="createForm.api_url" label="API URL" placeholder="http://66.45.237.70/api.php" />
                                                                  </div>

                                                                  <div class="col-12">
                                                                      <input type="text" v-model="createForm.api_user_name" label="API User Name" placeholder="e.g user name" />
                                                                  </div>

                                                                  <div class="col-12">
                                                                      <input type="text" v-model="createForm.api_user_pass" label="Api User Password" placeholder="e.g password" />
                                                                  </div>
                                                              </div>
                                                          </div>

                                                          <div class="col-md-6">
                                                              <table class="table table-bordered table-striped">
                                                                  <tbody>
                                                                      <tr>
                                                                          <th>Status</th>
                                                                          <th>Message</th>
                                                                      </tr>
                                                                      <tr>
                                                                          <td>1101</td>
                                                                          <td>Success</td>
                                                                      </tr>
                                                                      <tr>
                                                                          <td>1000</td>
                                                                          <td>Invalid user or Password</td>
                                                                      </tr>
                                                                      <tr>
                                                                          <td>1002</td>
                                                                          <td>Empty Number</td>
                                                                      </tr>
                                                                      <tr>
                                                                          <td>1003</td>
                                                                          <td>Invalid message or empty message</td>
                                                                      </tr>
                                                                      <tr>
                                                                          <td>1004</td>
                                                                          <td>Invalid number</td>
                                                                      </tr>
                                                                      <tr>
                                                                          <td>1005</td>
                                                                          <td>All Number is Invalid</td>
                                                                      </tr>
                                                                      <tr>
                                                                          <td>1006</td>
                                                                          <td>insufficient Balance</td>
                                                                      </tr>
                                                                      <tr>
                                                                          <td>1009</td>
                                                                          <td> Inactive Account</td>
                                                                      </tr>
                                                                      <tr>
                                                                          <td>1010</td>
                                                                          <td>Max number limit exceeded</td>
                                                                      </tr>
                                                                  </tbody>
                                                              </table>
                                                          </div>


                                                          <div class="col-12 mt-2 d-inline-flex align-item-center">
                                                              <button v-if="!isLoding" type="submit" disabled class="btn btn-primary me-1 waves-effect waves-float waves-light">
                                                                  <div class="spinner-border text-white me-1"  role="status"></div>
                                                                  <span>Submit</span>
                                                              </button>
                                                              <button class="btn btn-primary me-1 waves-effect waves-float waves-light">
                                                                  Submit
                                                              </button>
                                                              <button type="reset" class="btn btn-outline-secondary waves-effect">Reset</button>
                                                          </div>
                                                      </div>
                                                  </form>
                                              </div>
                                          </div>
                                      </div>-->
                                    <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                                        <div class="card">
                                            <h2>Frontend Setup</h2>
                                            <div class="card-body">
                                                <form class="form form-vertical" @submit.prevent="updateLogo()">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <Image v-model="logoForm.header_logo" :showFile="props.bSettings.header_logo" label="Header Logo"/>

                                                            <img :src="'/storage/'+props.bSettings.header_logo" width="100" height="70"
                                                                 v-if="typeof props.bSettings.header_logo === 'string'"
                                                                 style="object-fit: contain" alt="">
                                                        </div>
                                                        <div class="col-12">
                                                            <Image v-model="logoForm.footer_logo" :showFile="props.bSettings.footer_logo" label="Footer Logo"/>

                                                            <img :src="'/storage/'+props.bSettings.footer_logo" width="100" height="70"
                                                                 v-if="typeof props.bSettings.footer_logo === 'string'"
                                                                 style="object-fit: contain" alt="">
                                                        </div>
                                                        <div class="col-12">
                                                            <Image v-model="logoForm.logo_fabs" :showFile="props.bSettings.fevicon_logo" label="Favicon"/>
                                                            <img :src="'/storage/'+props.bSettings.fevicon_logo" width="100" height="70"
                                                                 v-if="typeof props.bSettings.fevicon_logo === 'string'"
                                                                 style="object-fit: contain" alt="">
                                                        </div>

<!--                                                        <div class="row">
                                                            <div class="col">
                                                                <label>Text Color</label> <small class="text-info">(Must Be HEXA Color. like #fefefe)</small>
                                                                 <Text type="color" v-model="logoForm.textColor" class="form-control form-control-color"/>
                                                            </div>
                                                            <div class="col">
                                                                <label>Main Color</label> <small class="text-info">(This is rgb color code rgb(255,255,255))</small>
                                                                <Text type="color" v-model="logoForm.mainColor" class="form-control form-control-color"/>
                                                            </div>
                                                            <div class="col">
                                                                <label>Light Color</label> <small class="text-info">(This is rgb color code rgb(255,255,255))</small>
                                                                <Text type="color" v-model="logoForm.lightColor"  class="form-control form-control-color"/>
                                                            </div>
                                                        </div>-->

                                                        <div class="col-12 mt-2 d-inline-flex align-item-center">
                                                            <button v-if="!isLoding" type="submit" disabled class="btn btn-primary me-1 waves-effect waves-float waves-light">
                                                                <div class="spinner-border text-white me-1"  role="status"></div>
                                                                <span>Submit</span>
                                                            </button>
                                                            <button v-else class="btn btn-primary me-1 waves-effect waves-float waves-light">
                                                                Submit
                                                            </button>
                                                            <button type="reset" class="btn btn-outline-secondary waves-effect">Reset</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="v-pills-shipping" role="tabpanel" aria-labelledby="v-pills-shipping_api-tab">
                                        <div class="card">
                                            <h2>Shipping Setting</h2>
                                            <div class="card-body d-flex justify-content-around">
                                                <div class="row">
                                                    <div class="col">
                                                        <form class="form form-vertical" @submit.prevent="updateBuisnessSetting()">
                                                            <div class="row">
                                                                <div class="">
                                                                    <label class="label card-text">Shipping Config</label>
                                                                    <select v-model="createForm.shippingType" @change="shiConfig" class="form-control form-select">
                                                                        <option value="null" disabled>Select Sipping Type</option>
                                                                        <option value="f">Free Shipping</option>
                                                                        <option value="p">Product Wish</option>
<!--                                                                        <option value="c">City Wise</option>-->
                                                                    </select>
                                                                </div>

                                                                <div class="d-flex align-items-center mt-1" v-if="shippingStatus === 'p'">
                                                                    <input type="text" class="form-control" v-model="createForm.inSizeDhaka" placeholder="Inside Dhaka" style="border-radius: 5px 0 0 5px;">
                                                                    <input type="text" class="form-control" v-model="createForm.outSizeDhaka" placeholder="Outside Dhaka" style="border-left: 0;border-radius: 0 5px 5px 0;">
                                                                </div>


                                                                <div class="col-12 mt-2 d-inline-flex align-item-center">
                                                                    <button v-if="!isLoding" type="submit" disabled class="btn btn-primary me-1 waves-effect waves-float waves-light">
                                                                        <div class="spinner-border text-white me-1"  role="status"></div>
                                                                        <span>Submit</span>
                                                                    </button>
                                                                    <button v-else class="btn btn-primary me-1 waves-effect waves-float waves-light">
                                                                        Submit
                                                                    </button>

                                                                    <button type="reset" class="btn btn-outline-secondary waves-effect">Reset</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="col">
                                                        <label>Options Work</label>
                                                        <ul class="list-group">
                                                            <li class="list-group-item">
                                                                1. Product Wise Shipping Cost calulation: Shipping cost is calculate by addition of each product shipping cost.
                                                            </li>
                                                            <li class="list-group-item">
                                                                2. Flat Rate Shipping Cost calulation: How many products a customer purchase, doesn't matter. Shipping cost is fixed.
                                                            </li>
                                                            <li class="list-group-item">
                                                                3. Seller Wise Flat Shipping Cost calulation: Fixed rate for each seller. If customers purchase 2 product from two seller shipping cost is calculated by addition of each seller flat shipping cost.
                                                            </li>
                                                            <li class="list-group-item">
                                                                4. Area Wise Flat Shipping Cost calulation: Fixed rate for each area. If customers purchase multiple products from one seller shipping cost is calculated by the customer shipping area. To configure area wise shipping cost go to Shipping Cities.
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="v-pills-home_cats" role="tabpanel" aria-labelledby="v-pills-home_cats">
                                        <div class="card">
                                            <h2>Add Some Categories</h2>
                                            <div class="card-body">
                                                <form class="form form-vertical" @submit.prevent="updateBuisnessSetting()">
                                                    <div class="">
                                                        <label class="label card-text">Shipping Config</label>
                                                        <vSelect :options="formattedParentCategories"
                                                                 multiple
                                                                 v-model="createForm.categoryId" label="label"
                                                                 :reduce="item =>item.value.id"
                                                                 placeholder="e.g Select Category">
                                                            <template v-slot:option="option">
                                                                <li class="d-flex align-items-start py-1">
                                                                    <div class="d-flex align-items-center justify-content-between w-100">
                                                                        <div class="me-1 d-flex flex-column">
                                                                            <h6 class="mb-25">{{ option.label }}</h6>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </template>
                                                        </vSelect>
                                                    </div>
                                                    <button class="btn btn-primary mt-1">Submit Settings</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="tab-pane fade" id="v-pills-menu" role="tabpanel" aria-labelledby="v-pills-menu">
                                        <div class="card">
                                            <h2>SMS API Credentials</h2>
                                            <div class="card-body">
                                                <form class="form form-vertical" @submit.prevent="updateBuisnessSetting()">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-md-12" data-repeater-item v-for="(value, index) in createForm.headerMenuSetup">
                                                                    <div class="card mb-0">
                                                                        <div class="card-body position-relative imgContainer">
                                                                            <h2 class="card-title">Menu {{ index+1}}</h2>
                                                                            <div class="mt-1">
                                                                                <input type="text" v-model="createForm.headerMenuSetup[index].title" class="form-control mb-1" placeholder="e.g Menu Title">
                                                                                <input type="text" v-model="createForm.headerMenuSetup[index].link" class="form-control mb-1" placeholder="e.g ?product=product-slug / category-slug">
                                                                            </div>

                                                                            <button
                                                                                v-if="index === createForm.headerMenuSetup.length - 1"
                                                                                class="btn btn-primary btn-sm float-end mt-25"
                                                                                type="button"
                                                                                name="button"
                                                                                @click="addRow">
                                                                                <vue-feather type="plus"/>
                                                                            </button>
                                                                            <button
                                                                                class="btn btn-danger btn-sm float-end mt-25 me-1"
                                                                                @click="deleteRow(index)"
                                                                                data-repeater-delete
                                                                                type="button">
                                                                                <vue-feather type="trash"/>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <h2 class="card-title">User Manual</h2>
                                                            <table class="table table-bordered table-striped">
                                                                <tbody>
                                                                <tr>
                                                                    <th>Type</th>
                                                                    <th>Value</th>
                                                                </tr>
                                                                <tr>
                                                                    <td>Products</td>
                                                                    <td>/product/single-product/PRODUCT_SLUG</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Categories</td>
                                                                    <td>/products?category=CATEGORY_SLUG</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Brands</td>
                                                                    <td>/products?brand=BRAND_SLUG</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Pages</td>
                                                                    <td>/pages/PAGE_SLUG</td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                        <div class="col-12 mt-2 d-inline-flex align-item-center">
                                                            <button v-if="!isLoding" type="submit" disabled class="btn btn-primary me-1 waves-effect waves-float waves-light">
                                                                <div class="spinner-border text-white me-1"  role="status"></div>
                                                                <span>Submit</span>
                                                            </button>
                                                            <button class="btn btn-primary me-1 waves-effect waves-float waves-light">
                                                                Submit
                                                            </button>
                                                            <button type="reset" class="btn btn-outline-secondary waves-effect">Reset</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="v-pills-home_content" role="tabpanel" aria-labelledby="v-pills-home_content">
                                        <div class="card">
                                            <h2>Home Content Setup</h2>
                                            <form class="form form-vertical" @submit.prevent="updateBuisnessSetting()">
                                                <div class="row">

                                                    <div class="col-12 mb-1">
                                                        <label>Home Products</label>
                                                        <vSelect :options="props.products"
                                                                 multiple
                                                                 v-model="createForm.home_products" label="title"
                                                                 :reduce="item => item.id"
                                                                 class="text-capitalize"
                                                                 placeholder="e.g Select Home Products">
                                                                <template v-slot:option="option">
                                                                    <li class="d-flex align-items-start py-1">
                                                                        <img :src="option.thumbnail" alt="" width="50" height="50">
                                                                        <div class="ms-1">
                                                                            <h6 class="mb-25">{{ option.title.slice(0, 30) }}</h6>
                                                                            <p>{{ option.category?.title }}</p>
                                                                        </div>
                                                                    </li>
                                                                </template>
                                                        </vSelect>
                                                    </div>


                                                    <div class="mt-2">
                                                        <label>Home Contents</label>
                                                        <Editor v-model="createForm.home_seo_content" isMultiline height="400px"/>
                                                    </div>

                                                    <div class="col-12 mt-2 d-inline-flex align-item-center">
                                                        <button v-if="!isLoding" type="submit" disabled class="btn btn-primary me-1 waves-effect waves-float waves-light">
                                                            <div class="spinner-border text-white me-1"  role="status"></div>
                                                            <span>Submit</span>
                                                        </button>

                                                        <button v-else class="btn btn-primary me-1 waves-effect waves-float waves-light">
                                                            Submit
                                                        </button>
                                                        <button type="reset" class="btn btn-outline-secondary waves-effect">Reset</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>


                                    <div class="tab-pane fade" id="v-pills-category_setup" role="tabpanel" aria-labelledby="v-pills-category_setup">
                                        <div class="card">
                                            <h2>Category Setup</h2>
                                            <form class="form form-vertical" @submit.prevent="updateBuisnessSetting()">
                                                <div class="row">
                                                    <div class="col-12 mb-1">
                                                        <label>Menu Categories</label>
                                                        <vSelect :options="props.categories"
                                                                 multiple
                                                                 v-model="createForm.menu_categories" label="title"
                                                                 :reduce="item => item.id"
                                                                 class="text-capitalize"
                                                                 placeholder="e.g Select menu categories">
                                                            <template v-slot:option="option">
                                                                <li class="d-flex align-items-start py-1">
                                                                    <img :src="option?.icon" alt="" width="50" height="50">
                                                                    <div class="ms-1">
                                                                        <h6 class="mb-25">{{ option.title.slice(0, 30) }}</h6>
                                                                    </div>
                                                                </li>
                                                            </template>
                                                        </vSelect>
                                                    </div>

                                                    <label>Featured Categories</label>
                                                    <vSelect :options="props.subCategories"
                                                             multiple
                                                             v-model="createForm.featured_categories" label="title"
                                                             :reduce="item => item.id"
                                                             class="text-capitalize"
                                                             placeholder="e.g Select featured categories">
                                                        <template v-slot:option="option">
                                                            <li class="d-flex align-items-start py-1">
                                                                <img :src="option?.icon" alt="" width="50" height="50">
                                                                <div class="ms-1">
                                                                    <h6 class="mb-25">{{ option.title.slice(0, 30) }}</h6>
                                                                </div>
                                                            </li>
                                                        </template>
                                                    </vSelect>


                                                    <div class="col-12 mt-2 d-inline-flex align-item-center">
                                                        <button v-if="!isLoding" type="submit" disabled class="btn btn-primary me-1 waves-effect waves-float waves-light">
                                                            <div class="spinner-border text-white me-1"  role="status"></div>
                                                            <span>Submit</span>
                                                        </button>

                                                        <button v-else class="btn btn-primary me-1 waves-effect waves-float waves-light">
                                                            Submit
                                                        </button>
                                                        <button type="reset" class="btn btn-outline-secondary waves-effect">Reset</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>


                                    <div class="tab-pane fade" id="v-pills-smtp" role="tabpanel" aria-labelledby="v-pills-smtp">
                                        <div class="card">
                                            <h2>SMTP Setup</h2>
                                            <form class="form form-vertical" @submit.prevent="updateMailSetup()">
                                                <div class="row">
                                                    <div class="col-12 mb-1">
                                                        <label>Mail Driver</label>
                                                        <vSelect :options="smtpMillers"
                                                                 v-model="mailSetup.mailDriver" label="name"
                                                                 :reduce="item =>item.name"
                                                                 class="text-capitalize"
                                                                 placeholder="e.g Mail Driver">
                                                        </vSelect>
                                                    </div>

                                                    <div class="col-12 mb-1">
                                                        <label>Mail Host</label>
                                                        <input type="text" class="form-control" v-model="mailSetup.mailHost" placeholder="e.g Mail Host" />
                                                    </div>

                                                    <div class="col-12 mb-1">
                                                        <label>Mail Port</label>
                                                        <input type="text" class="form-control" v-model="mailSetup.mailPort" placeholder="e.g Mail Port" />
                                                    </div>


                                                    <div class="col-12 mb-1">
                                                        <label>Username</label>
                                                        <input type="text" class="form-control" v-model="mailSetup.username" placeholder="e.g Username" />
                                                    </div>


                                                    <div class="col-12 mb-1">
                                                        <label>Password</label>
                                                        <input type="text" class="form-control" v-model="mailSetup.password" placeholder="e.g Password" />
                                                    </div>

                                                    <div class="col-12 mb-1">
                                                        <label>From Email</label>
                                                        <input type="text" class="form-control" v-model="mailSetup.fromEmail" placeholder="e.g Form Email" />
                                                    </div>

                                                    <div class="col-12 mb-1">
                                                        <label>From Name</label>
                                                        <input type="text" class="form-control" v-model="mailSetup.fromName" placeholder="e.g Form Name" />
                                                    </div>

                                                    <div class="col-12 mb-1">
                                                        <label>Encryption</label>
                                                        <select class="form-control" v-model="mailSetup.encryption">
                                                            <option disabled selected value="">Select Mail Encryption</option>
                                                            <option value="null">NULL</option>
                                                            <option value="tls">TLS</option>
                                                            <option value="ssl">SSL</option>
                                                        </select>
                                                    </div>


                                                    <div class="col-12 mt-2 d-inline-flex align-item-center">
                                                        <button v-if="!isLoding" type="submit" disabled class="btn btn-primary me-1 waves-effect waves-float waves-light">
                                                            <div class="spinner-border text-white me-1"  role="status"></div>
                                                            <span>Submit</span>
                                                        </button>

                                                        <button v-else class="btn btn-primary me-1 waves-effect waves-float waves-light">
                                                            Submit
                                                        </button>
                                                        <button type="reset" class="btn btn-outline-secondary waves-effect">Reset</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <Modal id="addShipCost" title="Add Area Wise Shipping Cost" size="sm" v-vb-is:modal>
        <div class="modal-body">
            <div class="">
                <label class="label">Inside Dhaka</label>
                <input type="text" v-model="formData.inSideDhaka" class="form-control" placeholder="e.g Inside Dhaka 100.00 ৳">
            </div>

            <div class="mt-1">
                <label class="label">Outside Dhaka</label>
                <input type="text" v-model="formData.outSideDhaka" class="form-control" placeholder="e.g Outside Dhaka 120.00 ৳">
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-success" data-bs-dismiss="modal" aria-label="Close">Ok</button>
        </div>
    </Modal>

</Layout>

</template>

<script setup>
import Image from '../../components/ImageUploader.vue'
import Modal from '../../components/Modal.vue'
import Layout from "../../Shared/Layout.vue";

import { usePage, useForm } from '@inertiajs/inertia-vue3'
import {computed, ref} from "vue"
import timezone from "../../Store/timezone";
import Editor from "../../components/Editor.vue";
const APP_URL = usePage().props.value.ADMIN_URL;

let props = defineProps({
    option:[],
    countries:"",
    errors:"",
    bSettings:"",
    main_url:String|null,
    updateSmtp:String|null,
    categories:[]|null,
    subCategories:[]|null,
    products:[]|null,
})

let countries = props.countries;
let options = timezone.timesones;

const shippingStatus = ref(null)
const shiConfig = (event) => shippingStatus.value = event.target.value;

const formData = useForm({
    inSideDhaka:null,
    outSideDhaka:null,
    shippingType:null,
})

let createForm = useForm({
    name        : props.bSettings.name ?? '',
    header_logo : props.bSettings.header_logo ?? '',
    logo_fabs   : props.bSettings.logo_fabs ?? '',
    footer_logo   : props.bSettings.logo_fabs ?? '',
    app_details : props.bSettings.details ?? '',
    timezone    : props.bSettings.timezone?.tz ?? '',
    country     : props.bSettings.country?.name ?? '',

    address     : props.bSettings.address ?? '',
    email       : props.bSettings.email ?? '',
    phone       : props.bSettings.phone ?? '',

    facebook_profile  : props.bSettings.facebook_profile ?? '',
    youtube           : props.bSettings.youtube ?? '',
    google_drive      : props.bSettings.google_drive ?? '',
    linkedin_profile  : props.bSettings.linkedin_profile ?? '',
    twitter_profile   : props.bSettings.twitter_profile ?? '',
    instagram_profile : props.bSettings.instagram_profile ?? '',

    api_url           : props.bSettings.api_url ?? '',
    api_user_name     : props.bSettings.api_user_name ?? '',
    api_user_pass     : props.bSettings.api_user_pass ?? '',

    home_seo_content  : props.bSettings.home_seo_content ?? '',

    inSizeDhaka:null,
    outSizeDhaka:null,
    shippingType:null,

    header_categories: props.bSettings.header_categories ?? [],

    home_products: props.bSettings.home_products ?? [],

    menu_categories: props.bSettings.menu_categories ?? [],
    featured_categories: props.bSettings.featured_categories ?? [],

    headerMenuSetup:props.bSettings.headerMenuSetup ?? [{
        link:usePage().props.value.auth.MAIN_URL

    }]



})

const mailSetup = useForm({
    mailDriver        : props.bSettings.mailDriver ?? '',
    mailHost          : props.bSettings.mailHost ?? '',
    mailPort          : props.bSettings.mailPort ?? '',
    username          : props.bSettings.username ?? '',
    password          : props.bSettings.password ?? '',
    fromEmail         : props.bSettings.fromEmail ?? '',
    fromName          : props.bSettings.fromName ?? '',
    encryption        : props.bSettings.encryption ?? '',
})

let addRow = () => {
    createForm.headerMenuSetup.push({
        title: '',
        link:usePage().props.value.auth.MAIN_URL
    })
}
let deleteRow = (index) => {
    createForm.headerMenuSetup.splice(index, 1)
}



let logoForm = useForm({
    header_logo     :   '',
    footer_logo     :   '',
    logo_fabs       :   '',
    lightColor      : null,
    mainColor       : null,
    textColor       : null

})


let isLoding = ref({});

let updateBuisnessSetting = () =>{
    isLoding.value = false
    createForm.post(props.main_url, {
        onSuccess: (res)=>{
            isLoding.value = true
            $sToast.fire({
               icon: "success",
               text: "Business Settings Update Successfully Done.:)",
            });
        },
        onError: (res) =>{
            isLoding.value = true
            $sToast.fire({
                icon: "error",
                text: "Business Settings Not Update (:",
            });
        }
    });
}


let updateLogo = () =>{
    isLoding.value = false
    logoForm.post(props.main_url, {
        onSuccess: (res)=>{
            isLoding.value = true
            $sToast.fire({
               icon: "success",
               text: "Business Settings Update Successfully Done.:)",
            });
        },
        onError: (res) =>{
            $sToast.fire({
                icon: "error",
                text: "Business Settings Not Update (:",
            });
        }
    });
}

let updateMailSetup = () =>{
    isLoding.value = false
    mailSetup.post(props.updateSmtp, {
        onSuccess: (res)=>{
            isLoding.value = true
            $sToast.fire({
               icon: "success",
               text: "Business Settings Update Successfully Done.:)",
            });
        },
        onError: (res) =>{
            $sToast.fire({
                icon: "error",
                text: "Business Settings Not Update (:",
            });
        }
    });
}

const renderOptionGroup = (categories, prefix = '') => {
    return categories.map((category) => {

        let cValue = '';
        for (let i = 0; i < category.order_level; i++) {
            cValue += '--';
        }
        const label = `${cValue}${category.title}`;
        if (category.children && category.children.length > 0) {
            const childPrefix = `${prefix}\xa0\xa0\xa0`;
            return {
                label,
                options: renderOptionGroup(category.children, childPrefix),
            };
        } else {
            const value = {...category};
            return {
                label,
                value,
            };
        }
    });
};

const smtpMillers = [
        {name:"smtp"}, {name:"sendmail"}, {name:"mailgun"}, {name:"ses"}, {name:"postmark"}, {name:"log"}, {name:"array"}, {name:"failover"}
]





const formattedParentCategories = computed(() => {
    return renderOptionGroup(props.categories);
});
</script>

<style scoped>
.spinner-border{
    --bs-spinner-width: 1.2rem !important;
    --bs-spinner-height: 1.2rem !important;
}
</style>
