using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VIndHeadcountArea : BDconexion
    {
        public List<EIndHeadcountArea> Listar_IndHeadcountArea()
        {
            List<EIndHeadcountArea> lCIndHeadcountArea = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CIndHeadcountArea oVIndHeadcountArea = new CIndHeadcountArea();
                    lCIndHeadcountArea = oVIndHeadcountArea.Listar_IndHeadcountArea(con);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCIndHeadcountArea);
        }
    }
}