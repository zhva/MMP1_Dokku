<?php
function parse(string $url): array {
    $params = array();
    $regex = "/(.+):\/\/(.+):(.+)@(.+):(\d+)\/(.*)/";
    preg_match($regex, $url, $matches);

    if ($matches[1] == "postgres") {
        $params["scheme"] = "pgsql";
    }

    $params["user"] = $matches[2];
    $params["password"] = $matches[3];
    $params["host"] = $matches[4];
    $params["port"] = $matches[5];
    $params["database"] = $matches[6];

    return $params;
}

function from_params(array $params): string {
    return $params["scheme"] . ":host=" . $params["host"] . ";port=" . $params["port"] . ";dbname=" . $params["database"];
}
?>
