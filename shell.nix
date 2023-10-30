{ pkgs ? import <nixpkgs> { } }:
pkgs.mkShell {
  nativeBuildInputs = with pkgs; [
    just
    nixfmt
    (pkgs.php.buildEnv {
      extensions = ({ enabled, all }: enabled ++ (with all; [ xdebug ]));
      extraConfig = ''
        xdebug.mode=debug
      '';
    })
    phpPackages.composer
    phpExtensions.xdebug
  ];
}
