def strip_url_params(url, params_to_strip = []):
    at = url.find("?")
    if at == -1:
        return url
    params = url[at + 1:].split("&")
    values = {}
    for item in params:
        (param, value) = item.split("=")
        if param not in params_to_strip + list(values.keys()):
            values[param] = value
    res = [k + "=" + values[k] for k in values.keys()]
    return url[:at] + "?" + "&".join(res)


from KataTestSuite import Test
test = Test()


test.assert_equals('www.codewars.com?a=1&b=2', strip_url_params('www.codewars.com?a=1&b=2&a=2'))
test.assert_equals('www.codewars.com?a=1', strip_url_params('www.codewars.com?a=1&b=2&a=2', ['b']))
test.assert_equals('www.codewars.com', strip_url_params('www.codewars.com', ['b']))