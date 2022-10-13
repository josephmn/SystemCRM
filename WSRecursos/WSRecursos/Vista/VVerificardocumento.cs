using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VVerificardocumento : BDconexion
    {
        public List<EVerificardocumento> Listar_Verificardocumento(String dni)
        {
            List<EVerificardocumento> lCVerificardocumento = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CVerificardocumento oVVerificardocumento = new CVerificardocumento();
                    lCVerificardocumento = oVVerificardocumento.Listar_Verificardocumento(con, dni);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCVerificardocumento);
        }
    }
}