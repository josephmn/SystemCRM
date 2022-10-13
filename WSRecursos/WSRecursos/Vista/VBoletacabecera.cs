using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VBoletacabecera : BDconexion
    {
        public List<EBoletacabecera> Listar_Boletacabecera(String nroboleta)
        {
            List<EBoletacabecera> lCBoletacabecera = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CBoletacabecera oVBoletacabecera = new CBoletacabecera();
                    lCBoletacabecera = oVBoletacabecera.Listar_Boletacabecera(con, nroboleta);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCBoletacabecera);
        }
    }
}