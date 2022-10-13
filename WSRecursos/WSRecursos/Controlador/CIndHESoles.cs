using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Collections.Specialized;
using System.Linq;
using System.Web;
using System.Data;
using System.Data.SqlClient;
using WSRecursos.Entity;

namespace WSRecursos.Controller
{
    public class CIndHESoles
    {
        public List<EIndHESoles> Listar_IndHESoles(SqlConnection con)
        {
            List<EIndHESoles> lEIndHESoles = null;
            SqlCommand cmd = new SqlCommand("ASP_INDHORASEXTRASSOLES", con);
            cmd.CommandType = CommandType.StoredProcedure;
            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEIndHESoles = new List<EIndHESoles>();

                EIndHESoles obEIndHESoles = null;
                while (drd.Read())
                {
                    obEIndHESoles = new EIndHESoles();
                    obEIndHESoles.v_periodo = drd["v_periodo"].ToString();
                    obEIndHESoles.f_HE25 = drd["f_HE25"].ToString();
                    obEIndHESoles.f_HE35 = drd["f_HE35"].ToString();
                    obEIndHESoles.f_HE100 = drd["f_HE100"].ToString();
                    obEIndHESoles.f_HEESP = drd["f_HEESP"].ToString();
                    lEIndHESoles.Add(obEIndHESoles);
                }
                drd.Close();
            }

            return (lEIndHESoles);
        }
    }
}