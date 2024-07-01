<?php
    namespace Asn\Model;
    class PanierModel {
        public $fournisseur = null;
        public $client = null;
        public array $articles = [];
        public $total = 0;
        public $observation = '';

        public function addArticle($article,$fournisseur,$qteAppro) {
            $montantArticle = $this->montantArticle($article["prixAppro"], $qteAppro);
            $key = $this->articleExist($article);
            if ($key != -1) {
                $this->articles[$key]["qteAppro"] += $qteAppro;
                $this->articles[$key]["montantArticle"] += $montantArticle;
            } else {
                $article["qteAppro"] += $qteAppro;
                $article["montantArticle"] = $montantArticle;
                $this->articles[] = $article;
            }
            $this->fournisseur = $fournisseur;
            $this->total += $montantArticle;
        }
        public function addArticleProduction($article,$qteProd,$observation) {
            $montantArticle = $this->montantArticle($article["prixAppro"], $qteProd);
            $key = $this->articleExist($article);
            if ($key != -1) {
                $this->articles[$key]["qteProd"] += $qteProd;
                $this->articles[$key]["montantArticle"] += $montantArticle;
            } else {
                $article["qteProd"] += $qteProd;
                $article["montantArticle"] = $montantArticle;
                $this->articles[] = $article;
            }
            $this->observation = $observation;
            $this->total += $montantArticle;
        }
        public function addArticleVente($article,$qteVente,$client,$observation) {
            $montantArticle = $this->montantArticle($article["prixAppro"], $qteVente);
            $key = $this->articleExist($article);
            if ($key != -1) {
                $this->articles[$key]["qteVente"] += $qteVente;
                $this->articles[$key]["montantArticle"] += $montantArticle;
            } else {
                $article["qteVente"] += $qteVente;
                $article["montantArticle"] = $montantArticle;
                $this->articles[] = $article;
            }
            $this->client = $client;
            $this->observation = $observation;
            $this->total += $montantArticle;
        }

        public function montantArticle($prix,$qteAppro): int {
            return $prix * $qteAppro;
        }

        public function articleExist($article): int {
            foreach($this->articles as $key => $value) {
                if ($value["articleId"] == $article["articleId"]) {
                    return $key;
                }
            }
            return -1;
        }

        public function clear() {
            $this->articles = [];
            $this->total = 0;
            $this->fournisseur = null;
        }
    }