using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VMantDocumentos : BDconexion
    {
        public List<EMantenimiento> MantDocumentos(String id, Int32 codigo, String dni, String directorio, String mime, String type)
        {
            List<EMantenimiento> lCEMantenimiento = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CMantDocumentos oVMantDocumentos = new CMantDocumentos();
                    lCEMantenimiento = oVMantDocumentos.MantDocumentos(con, id, codigo, dni, directorio, mime, type);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCEMantenimiento);
        }
    }
}