using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VBoletadetalle : BDconexion
    {
        public List<EBoletadetalle> Listar_Boletadetalle(String nroboleta)
        {
            List<EBoletadetalle> lCBoletadetalle = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CBoletadetalle oVBoletadetalle = new CBoletadetalle();
                    lCBoletadetalle = oVBoletadetalle.Listar_Boletadetalle(con, nroboleta);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCBoletadetalle);
        }
    }
}