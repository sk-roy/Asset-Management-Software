<template>
    <v-container>   
      <v-col cols="12">
      <v-row>
        <h3 v-if="asset.documents && asset.documents.length > 0">Documents</h3>
      </v-row>
      
      <!-- Display and Download Documents -->
      <v-row>
        <v-col cols="12">
          <v-list>
            <v-list-item
              v-for="(document, index) in asset.documents"
              :key="index"
            >
                <v-row>
                  <v-col>                    
                    <a
                      href="#"
                      @click.prevent="downloadDocument(document)"
                      class="p-1"
                      style="text-decoration: none"
                    >
                      <v-list-item-title>{{ document.title }}</v-list-item-title>
                    </a>
                    <v-list-item-subtitle>{{ formatDate(document.created_at) }}</v-list-item-subtitle>
                  </v-col>
                  <v-col>                    
                    <v-btn icon @click="deleteDocument(document)" variant="secondary">
                      <v-icon color="red">mdi-delete</v-icon>
                    </v-btn>    
                  </v-col>
                </v-row>
            </v-list-item>
          </v-list>
        </v-col>
      </v-row>

      <v-row>
        <v-col cols="8">
          <h4>Upload Document</h4>
          <v-file-input
            v-model="documentFile"
            label="Select a document"
            accept=".pdf,.doc,.docx,.jpg,.png"
            variant="outlined"
            density="compact"
            required
          ></v-file-input>
        </v-col>
        <v-col cols="4" class="d-flex align-center justify-center gap-10">
            <v-btn color="primary" @click="uploadDocument">Upload</v-btn>
        </v-col>
      </v-row>
  
    </v-col>    
    </v-container>
  </template>
  
  <script>
import apiClient from '@/plugins/axios';
import store from '@/store';
import { format } from 'date-fns';

  export default {
    props: {
      pAsset: Object,
    },
    data() {
      return {
        asset: this.pAsset,
        documentFile: null, // Holds the selected file
      };
    },
    methods: {

      async uploadDocument() {
        try {
          if (!this.documentFile) return;
    
          const formData = new FormData();
          formData.append('document', this.documentFile);
          formData.append('asset_id', this.pAsset.id);
    
          const response = await apiClient.post(`/documents`, formData, {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          });

          if (response.data.success) {
            this.documentFile = null;
            this.reloadAsset();
          }
        
        } catch (error) {
          console.error("Document upload failed:", error);
          alert("Failed to upload the document.");
        }
      },
  
      // Handle document download
      async downloadDocument(file) {
        console.log('downloadDocument');
        try {
          const response = await apiClient.get(`/documents/${file.id}`, {
            responseType: "blob",
          });

          
          console.log('downloadDocument', response);

          const url = window.URL.createObjectURL(new Blob([response.data]));
          const link = document.createElement("a");
          link.href = url;
          link.setAttribute("download", file.title);
          document.body.appendChild(link);
          link.click();
          link.remove();
        } catch (error) {
          console.error("Document download failed:", error);
          alert("Failed to download the document.");
        }
      },

      async deleteDocument(document) {
        if (confirm("Are you sure?")) {
          try {
            await apiClient.delete(`/documents/${document.id}`);
            this.reloadAsset();
          } catch (error) {
            console.error("Failed to delete document:", error);
            alert("Failed to delete the document.");
          }
        }
      },
        
      async reloadAsset() {
          await store.dispatch('fetchAssetDetails', { id: this.pAsset.id });
          this.asset = store.getters.getAssetDetails(this.pAsset.id);
          console.log('reloadAsset', this.pAsset.documents);
      },
    
      formatDate(date) {
          return format(date, 'hh:mm a, MMMM dd, yyyy');
      },
    },
    mounted() {
    }
  };
  </script>
  